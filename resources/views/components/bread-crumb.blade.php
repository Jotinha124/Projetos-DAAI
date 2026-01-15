<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route($layer1route) }}">{{ $layer1 }}</a></li>
            @if ($layer2route)
                <li class="breadcrumb-item">
                    <a href="{{ route($layer2route) }} ">{{ $layer2 }}</a>
                </li>
            @else
                <li class="breadcrumb-item @if(!$layer3) active" aria-current="page" @endif>
                    {{ $layer2 }}
                </li>
            @endif
            @if ($layer3)
                <li class="breadcrumb-item active" aria-current="page">{{ $layer3 }}</li>
            @endif
        </ol>
    </nav>
</div>
