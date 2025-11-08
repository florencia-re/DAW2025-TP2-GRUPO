@if ($errors->any())
  <div class="bg-red-100 text-red-700 p-3 rounded mb-3">
    <ul class="list-disc list-inside">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

@foreach (['success','error','info'] as $t)
  @if (session($t))
    <div class="p-3 rounded mb-3
      {{ $t === 'success' ? 'bg-green-100 text-green-800' : '' }}
      {{ $t === 'error' ? 'bg-red-100 text-red-800' : '' }}
      {{ $t === 'info' ? 'bg-blue-100 text-blue-800' : '' }}">
      {{ session($t) }}
    </div>
  @endif
@endforeach
