<div style="display: flex; align-items: center; gap: 12px; min-width: max-content;">
    @if($logo)
        <img src="{{ $logo }}"
             alt="Logo"
             style="height: 36px; width: auto; flex-shrink: 0; object-fit: contain;">
    @endif

    <span style="font-size: 1.25rem; font-weight: 700; letter-spacing: -0.025em; line-height: 1; white-space: nowrap;"
          class="text-gray-950 dark:text-white">
        {{ $name }}
    </span>
</div>

