<div>
    {{--    @if(!empty($output))--}}
    {{--        @foreach($output as $o)--}}
    {{--            {{ $o }}--}}
    {{--        @endforeach--}}
    {{--    @endif--}}
    @if(isset($returnVar))
    Something went wrong
    @else
        {{ $string }}
    @endif
</div>

