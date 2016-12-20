@extends('layouts.app')

@section('content')

  <div class="content-wrapper">

    <div class="contact-wrapper">
      <div class="contact-info">
        <h1>Contact Us</h1>
        <h3>Hello, <span>Username!</span></h3>
      </div>
      <div class="contact-form">
        <label class="form-heading" for="contact-msg">What can we do for you?</label>
        <textarea id="contact-msg" placeholder="Write your message here"></textarea>
        <button class="save-button pr-button">Send</button>
      </div>

    </div>

  </div>
@endsection
