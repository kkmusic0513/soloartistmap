<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;
use Image;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    // 単一イベント表示（公開）
    public function show(Event $event)
    {
        // 承認済みかつ公開中のアーティストのイベントのみ表示
        if (!$event->artist->is_approved || !$event->artist->is_public) {
            abort(404);
        }

        return view('events.show', compact('event'));
    }

    // イベント一覧（ダッシュボード用）
    public function index(Artist $artist)
    {
        $this->authorize('update', $artist); // 所有者または管理者のみ
        $events = $artist->events()->orderBy('start_at')->paginate(20);
        return view('events.index', compact('artist', 'events'));
    }

    // 作成フォーム
    public function create(Artist $artist)
    {
        $this->authorize('update', $artist);
        return view('events.create', compact('artist'));
    }

    // 保存
    public function store(Request $request, Artist $artist)
    {
        $this->authorize('update', $artist);

        try {

            // カスタムバリデーション: end_date, end_hour, end_minuteの整合性チェック
            $endDateFilled = $request->filled('end_date');
            $endHourFilled = $request->filled('end_hour');
            $endMinuteFilled = $request->filled('end_minute');

            // STARTが完全に設定されているか、完全に未設定かのチェック
            if ($endDateFilled && (!$endHourFilled || !$endMinuteFilled)) {
                // end_dateが設定されているのにend_hourまたはend_minuteが未設定
                $errors = [];
                if (!$endHourFilled) $errors['end_hour'] = '終了時間を選択してください。';
                if (!$endMinuteFilled) $errors['end_minute'] = '終了分を選択してください。';
                throw \Illuminate\Validation\ValidationException::withMessages($errors);
            }

            if (($endHourFilled || $endMinuteFilled) && !$endDateFilled) {
                // end_hourまたはend_minuteが設定されているのにend_dateが未設定
                throw \Illuminate\Validation\ValidationException::withMessages(['end_date' => '終了日付を入力してください。']);
            }

            $request->validate([
                'end_date' => 'nullable|date',
                'end_hour' => 'nullable|numeric|between:0,23',
                'end_minute' => 'nullable|numeric|between:0,59',
            ]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'start_date' => 'required|date',
                'start_hour' => 'required|numeric|between:0,23',
                'start_minute' => 'required|numeric|between:0,59',
                'end_date' => 'nullable|date',
                'end_hour' => 'nullable|numeric|between:0,23',
                'end_minute' => 'nullable|numeric|between:0,59',
                'location' => 'nullable|string|max:255',
                'photo' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:10240', // 10MB
                    'dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
                ],
            ], [
            'title.required' => 'イベント名は必須です。',
            'title.max' => 'イベント名は255文字以内で入力してください。',

            'description.max' => '説明は1000文字以内で入力してください。',

            'start_date.required' => '開始日付は必須です。',
            'start_date.date' => '開始日付は正しい日付形式で入力してください。',
            'start_hour.required' => '開始時間を選択してください。',
            'start_hour.between' => '開始時間は0-23の範囲で入力してください。',
            'start_minute.required' => '開始分を選択してください。',
            'start_minute.between' => '開始分は0-59の範囲で入力してください。',

            'end_date.date' => '終了日付は正しい日付形式で入力してください。',
            'end_hour.between' => '終了時間は0-23の範囲で入力してください。',
            'end_minute.between' => '終了分は0-59の範囲で入力してください。',

            'location.max' => '場所は255文字以内で入力してください。',

            'photo.image' => '写真は画像ファイルを選択してください。',
            'photo.mimes' => '写真はJPEG、PNG、GIF、WebP形式のみ対応しています。',
            'photo.max' => '写真のサイズは10MB以下にしてください。',
            'photo.dimensions' => '写真のサイズは幅100-8000px、高さ100-8000pxの範囲にしてください。',
        ]);

        // 日時を組み立てる
        $validated['start_at'] = $validated['start_date'] . ' ' . sprintf('%02d', $validated['start_hour']) . ':' . $validated['start_minute'] . ':00';

        if (!empty($validated['end_date'])) {
            $validated['end_at'] = $validated['end_date'] . ' ' . sprintf('%02d', $validated['end_hour'] ?? 0) . ':' . ($validated['end_minute'] ?? '00') . ':00';
        } else {
            $validated['end_at'] = null;
        }

        // 不要なフィールドを削除
        unset($validated['start_date'], $validated['start_hour'], $validated['start_minute'], $validated['end_date'], $validated['end_hour'], $validated['end_minute']);

        // 画像保存・圧縮処理
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.jpg'; // 拡張子は必ずjpgに
            $eventDir = storage_path('app/public/events');
            if (!file_exists($eventDir)) mkdir($eventDir, 0755, true);

            $path = $eventDir . '/' . $filename;

            // 画像を圧縮して保存
            Image::make($file)
                ->resize(1600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 75) // 品質75%で保存
                ->save($path);

            $validated['photo'] = 'events/' . $filename;
        }

        $artist->events()->create($validated);

        return redirect()->route('artist.events.index', $artist)->with('success', 'イベントを追加しました');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Event validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Event creation failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return back()->with('error', 'イベントの登録に失敗しました。')->withInput();
        }
    }

    // 編集フォーム
    public function edit(Artist $artist, Event $event)
    {
        $this->authorize('update', $artist);
        return view('events.edit', compact('artist', 'event'));
    }

    // 更新
    public function update(Request $request, Artist $artist, Event $event)
    {
        $this->authorize('update', $artist);

        try {
            // カスタムバリデーション: end_date, end_hour, end_minuteの整合性チェック
            $endDateFilled = $request->filled('end_date');
            $endHourFilled = $request->filled('end_hour');
            $endMinuteFilled = $request->filled('end_minute');

            // STARTが完全に設定されているか、完全に未設定かのチェック
            if ($endDateFilled && (!$endHourFilled || !$endMinuteFilled)) {
                // end_dateが設定されているのにend_hourまたはend_minuteが未設定
                $errors = [];
                if (!$endHourFilled) $errors['end_hour'] = '終了時間を選択してください。';
                if (!$endMinuteFilled) $errors['end_minute'] = '終了分を選択してください。';
                throw \Illuminate\Validation\ValidationException::withMessages($errors);
            }

            if (($endHourFilled || $endMinuteFilled) && !$endDateFilled) {
                // end_hourまたはend_minuteが設定されているのにend_dateが未設定
                throw \Illuminate\Validation\ValidationException::withMessages(['end_date' => '終了日付を入力してください。']);
            }

            $request->validate([
                'end_date' => 'nullable|date',
                'end_hour' => 'nullable|numeric|between:0,23',
                'end_minute' => 'nullable|numeric|between:0,59',
            ]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'required|date',
                'start_hour' => 'required|numeric|between:0,23',
                'start_minute' => 'required|numeric|between:0,59',
                'end_date' => 'nullable|date',
                'end_hour' => 'nullable|numeric|between:0,23',
                'end_minute' => 'nullable|numeric|between:0,59',
                'location' => 'nullable|string|max:255',
                'photo' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:10240', // 10MB
                    'dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
                ],
                ]);

            // 日時を組み立てる
            $validated['start_at'] = $validated['start_date'] . ' ' . sprintf('%02d', $validated['start_hour']) . ':' . $validated['start_minute'] . ':00';

            if (!empty($validated['end_date'])) {
                $validated['end_at'] = $validated['end_date'] . ' ' . sprintf('%02d', $validated['end_hour'] ?? 0) . ':' . ($validated['end_minute'] ?? '00') . ':00';
            } else {
                $validated['end_at'] = null;
            }

            // 不要なフィールドを削除
            unset($validated['start_date'], $validated['start_hour'], $validated['start_minute'], $validated['end_date'], $validated['end_hour'], $validated['end_minute']);

        // 画像保存・圧縮処理
        if ($request->hasFile('photo')) {
            // 既存画像削除
            if ($event->photo && file_exists(storage_path('app/public/' . $event->photo))) {
                unlink(storage_path('app/public/' . $event->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.jpg'; // 拡張子は必ずjpgに
            $eventDir = storage_path('app/public/events');
            if (!file_exists($eventDir)) mkdir($eventDir, 0755, true);

            $path = $eventDir . '/' . $filename;

            // 画像を圧縮して保存
            Image::make($file)
                ->resize(1600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 75) // 品質75%で保存
                ->save($path);

            $validated['photo'] = 'events/' . $filename;
        }

            $event->update($validated);

            return redirect()->route('artist.events.index', $artist)->with('success', 'イベントを更新しました');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Event update validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Event update failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return back()->with('error', 'イベントの更新に失敗しました。')->withInput();
        }
    }

    // 削除
    public function destroy(Artist $artist, Event $event)
    {
        $this->authorize('update', $artist);

        if ($event->photo && file_exists(storage_path('app/public/' . $event->photo))) {
            unlink(storage_path('app/public/' . $event->photo));
        }

        $event->delete();

        return redirect()->route('artist.events.index', $artist)->with('success', 'イベントを削除しました');
    }
}
