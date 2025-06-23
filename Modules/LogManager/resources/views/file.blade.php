@extends('LogManager::layouts.master')

@section('content')
    <div class="container">
        <h1>{{ logLocalize("Log File") }}: {{ $fileName }}</h1>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                   {{ logLocalize("File Contents") }}
                    <span class="badge bg-primary">
                        {{ logLocalize("Total Entries") }}: {{ $fileContents->total() }}
                    </span>

                    @if(!empty($searchTerm))
                        <span class="badge bg-success">
                            {{ logLocalize("Total Matched found") }} : {{ $matchedCount ?? 0 }} for {{ $searchTerm ?? null  }}
                        </span>
                    @endif
                </div>

                <form action="{{ route('admin.logs.file', ['folderName' => $folderName, 'fileName' => $fileName]) }}" method="GET" class="d-flex">
                    <input type="text"
                           name="search"
                           class="form-control me-2"
                           placeholder="Search admin.logs..."
                           value="{{ $searchTerm ?? '' }}"
                           style="width: 250px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> {{ logLocalize("Search") }}
                    </button>
                    @if(!empty($searchTerm))
                        <a href="{{ route('admin.logs.file', ['folderName' => $folderName, 'fileName' => $fileName]) }}"
                           class="btn btn-secondary ms-2">
                            {{ logLocalize("Clear") }}
                        </a>
                    @endif
                </form>
            </div>


            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped log-table">
                    <thead>
                        <tr>
                            <th>{{ logLocalize("SL") }}</th>
                            <th>{{ logLocalize("Date Time") }}</th>
                            <th>{{ logLocalize("Content") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($fileContents as $line)
                        @php
                            // Extract datetime and content
                            preg_match('/\[(.*?)\] (.*?)(?:\.([A-Z]+))?:\s*(.*)$/', $line, $matches);

                            // Check if we have a valid match
                            $datetime = $matches[1] ?? 'N/A';
                            $content = $matches[4] ?? $line;

                            // Highlight search term if exists
                            $highlightedContent = $content;
                            if (!empty($searchTerm)) {
                                $highlightedContent = preg_replace(
                                    '/(' . preg_quote($searchTerm, '/') . ')/i',
                                    '<mark>$1</mark>',
                                    $content
                                );
                            }

                            // Try to parse JSON
                            $parsedContent = null;
                            $originalContent = $content;
                            try {
                                $parsedContent = json_decode($content, true);
                            } catch (Exception $e) {
                                $parsedContent = null;
                            }
                        @endphp
                        @if(!empty(trim($line)))
                            <tr>
                                <td>{{ ($fileContents->currentPage() - 1) * $fileContents->perPage() + $loop->index + 1 }}</td>
                                <td width="15%">{{ $datetime }}</td>
                                <td width="74%">
                                    @if($parsedContent && is_array($parsedContent))
                                        <table class="table table-sm table-bordered mb-0">
                                            @foreach($parsedContent as $key => $value)
                                                <tr>
                                                    <td class="font-weight-bold" width="30%">{{ $key }}</td>
                                                    <td>
                                                        @if(is_array($value))
                                                            <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                        @else
                                                            {!!
                                                                !empty($searchTerm)
                                                                    ? preg_replace(
                                                                        '/(' . preg_quote($searchTerm, '/') . ')/i',
                                                                        '<mark>$1</mark>',
                                                                        $value
                                                                    )
                                                                    : $value
                                                            !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        {!!
                                            !empty($searchTerm)
                                                ? preg_replace(
                                                    '/(' . preg_quote($searchTerm, '/') . ')/i',
                                                    '<mark>$1</mark>',
                                                    $highlightedContent
                                                )
                                                : $highlightedContent
                                        !!}
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $fileContents->appends(['search' => $searchTerm])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

        <div class="mt-3">
            @php
                $folderName = $folderName != "root" ? $folderName : "";
            @endphp
            <a href="{{ route('admin.logs.folder', $folderName) }}" class="btn btn-secondary">
                {{ logLocalize("Back to") }} {{ $folderName }} {{ logLocalize("Folder") }}
            </a>
        </div>
    </div>

    <style>
        .log-table {
            font-size: 14px;
        }
        .log-content-line {
            background-color: transparent;
            border: none;
            margin: 0;
            padding: 0;
            white-space: pre-wrap;
            word-break: break-all;
        }
        mark {
            background-color: yellow;
            color: black;
            padding: 0;
        }
    </style>
@endsection



    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Optional: Scroll to first highlighted item
                const firstHighlight = document.querySelector('mark');
                if (firstHighlight) {
                    firstHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        </script>
    @endpush