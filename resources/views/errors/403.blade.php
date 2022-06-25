@extends('errors::minimal')

@section('title', __('http_error.client_side.403'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'http_error.client_side.403'))
