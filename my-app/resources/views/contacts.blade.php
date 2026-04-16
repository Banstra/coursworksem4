@extends('layouts.app')
@section('title', 'Контакты')
@section('content')
<h1>Контакты</h1>
<ul style="list-style: none; padding: 0;">
    @foreach($contacts as $item)
    <li style="margin-bottom: 8px; padding: 8px; background: #f8f9fa; border-radius: 4px;">
        <strong>{{ $item['type'] }}:</strong> {{ $item['value'] }}
    </li>
    @endforeach
</ul>
@endsection