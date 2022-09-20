<style>
    .table > tbody > tr > td {
        vertical-align: middle;
    }
</style>
@if(empty($responsive))
    @php($responsive = '')
@endif
@if(empty($padding))
    @php($padding = '')
@endif
@component('component.panels.basic',['title' => $title, 'responsive' => $responsive, 'padding' => $padding])
    @if(!empty($boxTool))
        @slot('boxTool')
            {{ $boxTool }}
        @endslot
    @endif
    @slot('body')
        <table class="table table-bordered">
            <thead>
            <tr>
                @foreach($headerNameTable as $name)
                    <th>{{ $name }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            {{ $dataTable }}
            </tbody>
        </table>
    @endslot
    @slot('footer')
        {{ $footer }}
    @endslot
@endcomponent
