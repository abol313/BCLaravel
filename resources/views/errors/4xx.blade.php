@extends('errors::minimal')

@section('title', __('http_error.client_side.4xx'))
@section('code', $exception->getStatusCode())
@section('message', __('http_error.client_side.4xx'))
