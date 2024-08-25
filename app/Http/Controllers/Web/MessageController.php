<?php

namespace App\Http\Controllers\Web;

use App\Models\Message;

use App\Jobs\ProcessMessageJob;

class MessageController extends WebController
{
    public function index()
    {
        $messages = $this->getMessages();

        return view('pages.messages.index', [
            'messages' => $messages,
        ]);
    }

    protected function getMessages()
    {
        $builder = Message::query();

        if (request()->query('query')) {
            $builder->where('source_url', 'like', '%' . request()->query('query') . '%');
        }

        $builder->orderBy('id', 'desc');

        return $builder->paginate();
    }

    public function create()
    {
        return view('pages.messages.create');
    }

    public function store()
    {
        $data = request()->validate([
            'source_url' => 'required|string',
        ]);

        try {
            Message::create($data);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            $exists = Message::withTrashed()->where('source_url', $data['source_url'])->first();

            if ($exists) {
                if ($exists->deleted_at) {
                    $exists->restore();

                    return redirect()->route('messages.index')->with('success', 'Message restored successfully');
                }

                return redirect()->route('messages.index')->with('error', 'Message already exists');
            }

            throw $e;
        }

        return redirect()->route('messages.index')->with('success', 'Message created successfully');
    }

    public function edit(Message $message)
    {
        return view('pages.messages.edit', [
            'message' => $message,
        ]);
    }

    public function update(Message $message)
    {
        $data = request()->validate([
            'source_url' => 'required|string',
        ]);

        $message->update($data);

        return redirect()->route('messages.index')->with('success', 'Message updated successfully');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('messages.index')->with('success', 'Message deleted successfully');
    }

    public function process(Message $message)
    {
        ProcessMessageJob::dispatch($message);

        return redirect()->route('articles.show', $message->article->id)->with('success', 'Message processed successfully');
    }

    public function publish(Message $message)
    {
        $released_at = now();

        if ($message->article->artifacts->released_at) {
            $released_at = null;
        }

        $message->article->artifacts->update([
            'released_at' => $released_at,
        ]);

        return redirect()->route('articles.show', $message->article->id)->with('success', 'Message published successfully');
    }
}
