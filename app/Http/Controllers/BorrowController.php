<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use App\Models\Genre;
use PhpMqtt\Client\MqttClient;

class BorrowController extends Controller
{
    public function index()
    {
$books = Book::where('is_available', true)->get();
$borrowedBooks = Book::where('is_available', false)->get();
$genres = Genre::all();

return view('borrow.index', compact('books', 'borrowedBooks', 'genres'));
    }

public function borrowBook(Request $request)
{

    $request->validate([
        'book_id' => 'required|exists:books,id',
    ]);

    // 1. находим книгу + локацию
    $book = Book::with('location')->findOrFail($request->book_id);

    if (!$book->is_available) {
        return back()->with('error', 'Dieses Buch ist bereits ausgeliehen.');
    }

    // 2. создаём запись
    Borrowing::create([
        'book_id' => $book->id,
        'borrowed_at' => now(),
    ]);

    // 3. обновляем статус
    $book->update([
        'is_available' => false,
    ]);

    // 4. берём номер секции
    if (!$book->location) {
        return back()->with('error', 'Keine Location gefunden');
    }

    $section = (int) $book->location->section_number;
    // 5. отправляем в MQTT
    $mqtt = new MqttClient('127.0.0.1', 1883);
    $mqtt->connect();

    $mqtt->publish('library/shelf', (string)$section);

    $mqtt->disconnect();

    return back()->with('success', 'Buch wurde erfolgreich ausgeliehen.');
}
}
