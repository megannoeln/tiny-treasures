<p>You received a new {{ $inquiry->type }} inquiry.</p>

@if ($inquiry->artwork)
    <p><strong>Item:</strong> {{ $inquiry->artwork->title }}</p>
    <p>
        <strong>Item link:</strong>
        <a href="{{ $inquiry->artwork->is_for_sale ? route('shop.show', $inquiry->artwork) : route('portfolio.show', $inquiry->artwork) }}">
            {{ $inquiry->artwork->is_for_sale ? 'Shop page' : 'Portfolio page' }}
        </a>
    </p>
@endif

<p><strong>Name:</strong> {{ $inquiry->name ?: '—' }}<br>
<strong>Email:</strong> {{ $inquiry->email }}</p>

<p><strong>Message:</strong></p>
<pre style="white-space: pre-wrap; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;">{{ $inquiry->message }}</pre>
