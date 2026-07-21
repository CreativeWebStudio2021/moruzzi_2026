@extends('emails.layout')

@section('preinfo')
@stop

@section('image')
@stop

@section('content')
<div class="content" style="padding-top:0">
    <div class="order-info">
        <br/><br/>
        {!! __('emails.admin_registration_intro', [
            'name' => '<b>'.e($cognome).' '.e($nome).'</b>',
            'date' => '<b>'.e($dataIscrizione).'</b>',
        ]) !!}
        <br><br>
        {{ __('emails.admin_registration_data_intro') }}
        <br/><br/>
        <b>{{ __('contact.name') }}</b>: {{ $nome }}<br/>
        <b>{{ __('contact.surname') }}</b>: {{ $cognome }}<br/>
        <b>{{ __('contact.email') }}</b>: {{ $email }}
        <br/><br/>
    </div>
</div>
@stop
