@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>CSV Import</h3></div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('import_process') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

                            <table class="table">
                                @foreach ($csv_data as $row)
                                    <tr>
                                    @foreach ($row as $key => $value)
                                        <td>{{ $value }}</td>

                                    @endforeach
                                    </tr>
                                @endforeach
                            </table>

                            <a href="/employees" class="btn btn-danger float-right ml-3">Cancel</a>
                            <button type="submit" class="btn btn-primary float-right">
                                Import Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
