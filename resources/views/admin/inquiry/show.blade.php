@extends('admin.layout.app')

@section('title', 'Inquiry')

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Inquiries', 'link' => route('inquiries.index'), 'addOrEdit' => 'show', 'name' => ''])
        <div class="content">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold">
                            {{ getConstant('SITE_NAME') }}
                            <small class="float-right">Date: {{ $inquiry->created_at->format('d-m-Y h:i') }}</small>
                        </h4>
                    </div>
                </div>
                <hr>
                <div class="row invoice-info">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="name">Name</label>
                                    <input disabled type="text" value="{{ ucfirst($inquiry->first_name . ' ' . $inquiry->last_name) }}" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="name">Mobile Number</label>
                                    <input disabled type="text" value="{{ $inquiry->phone }}" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label for="code">Email</label>
                                    <input type="text" disabled value="{{ $inquiry->email }}" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="description">Message</label>
                                    <textarea rows="7" type="text" disabled class="form-control">{{ $inquiry->message }}</textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
