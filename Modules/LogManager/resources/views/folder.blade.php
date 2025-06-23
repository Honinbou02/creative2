@extends('LogManager::layouts.master')

@section('content')
    <div class="container">
        <h1>Log Files in {{ $folderName }} Folder</h1>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>File Name</th>
                <th>Size (bytes)</th>
                <th>Last Modified</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logFiles as $file)
                <tr>
                    <td>{{ formatLogName($file['name']) }}</td>
                    <td>{{ $file['size'] }}</td>
                    <td>{{ date('Y-m-d H:i:s', $file['last_modified']) }}</td>
                    <td>
                        <a href="{{ route('admin.logs.file', ['folderName' => $folderName, 'fileName' => $file['name']]) }}"
                           class="btn btn-sm btn-primary">
                            View Contents
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary">Back to Log Folders</a>
    </div>
@endsection