<?php
$chat_rooms = [
    'room1' => [
        'id' => 'room1',
        'name' => 'General',
    ],
    'room2' => [
        'id' => 'room2',
        'name' => 'Life Style',
    ],
    'room3' => [
        'id' => 'room3',
        'name' => 'Food & Drink',
    ],
    'room4' => [
        'id' => 'room4',
        'name' => 'Sports',
    ],
    'room5' => [
        'id' => 'room5',
        'name' => 'Fashion',
    ],
];

function getRoomById($room_id) {
    global $chat_rooms;
    return $chat_rooms[$room_id] ?? null;
}