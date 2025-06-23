@extends('LogManager::layouts.master')

@section('content')
    <div class="container">
        <h1>{{ logLocalize("Log Folders and Files") }}</h1>

        <div class="row">
            <div class="col-md-4">
                <h2>{{ logLocalize("Log Folders") }}</h2>
                <ul class="list-group">
                    @foreach($logFolders as $folder)
                        <li class="list-group-item">
                            <a href="{{ route('admin.logs.folder', $folder) }}">
                                {{ formatLogName($folder)  }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-6">
                <h2>{{ logLocalize("Root Log Files") }}</h2>
                <ul class="list-group">
                    @foreach($rootLogFiles as $file)
                        <li class="list-group-item">
                            <a href="{{ route('admin.logs.file', ['folderName' => 'root', 'fileName' => $file]) }}">
                                {{ $file }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection