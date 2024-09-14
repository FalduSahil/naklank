<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @if($link)
                        <li class="breadcrumb-item">@if($addOrEdit == 'add' || $addOrEdit == 'edit' || $addOrEdit == 'show') <a href="{{ $link }}">{{ $title }}</a> @else {{ $title }} @endif</li>
                    @endif
                    @if($addOrEdit == 'add')
                        <li class="breadcrumb-item">Add {{ $title }}</li>
                    @elseif($addOrEdit == 'edit')
                        <li class="breadcrumb-item">Edit {{ $title }}</li>
                    @elseif($addOrEdit == 'show')
                        <li class="breadcrumb-item">{{ $name }}</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
