@extends('layouts.app')


@section('content')
  <div class="container">
    <h1>Create Event</h1>
    <form method="post" action="{{ route('saveEvents') }}">
      @csrf
      <div class="form-group">
        <label for="event-name">Event Name</label>
        <input type="text" class="form-control" id="eventName" name="eventName">
      </div>
      <div class="form-group">
        <label for="start-date">Start Date</label>
        <input type="date" class="form-control" id="startDate" name="startDate">
      </div>
      <div class="form-group">
        <label for="end-date">End Date</label>
        <input type="date" class="form-control" id="endDate" name="endDate">
      </div>
      <div class="form-group">
      <h4>Invite Users</h4>
    @foreach($users as $user)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="invited_users[]" value="{{ $user->id }}" id="{{ $user->id }}">
            <label class="form-check-label" for="{{ $user->id }}">
                {{ $user->fname }}  {{ $user->lname }} - ({{ $user->email }})
            </label>
        </div>
    @endforeach
    </div>
      <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
  </div>
@endsection