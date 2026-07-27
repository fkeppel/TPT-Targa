@if (is_array($data) || is_object($data))
    <details style="margin-left: {{ $level * 16 }}px;">
        <summary style="cursor:pointer;">
            {{ is_array($data) ? 'Array' : 'Object' }}
            ({{ count((array) $data) }})
        </summary>
        @foreach ((array) $data as $key => $value)
            <div style="margin-top:4px;">
                <strong>{{ $key }}</strong> :
                @if (is_array($value) || is_object($value))
                    @include('debug.tree', array(
                        'data' => $value,
                        'level' => $level + 1
                    ))
                @else
                    <span style="color:#0a7;">{{ var_export($value, true) }}</span>
                @endif
            </div>
        @endforeach
    </details>
@else
    <span>{{ var_export($data, true) }}</span>
@endif