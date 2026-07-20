@php($n = $name ?? '')
<svg class="{{ $class ?? 'h-5 w-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
@switch($n)
@case('home')<path d="M4 11.5 12 5l8 6.5"/><path d="M6 10.5V19h12v-8.5"/>@break
@case('projects')<rect x="3.5" y="3.5" width="7" height="7" rx="1.6"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.6"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.6"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.6"/>@break
@case('inspiration')<path d="M12 3.5l1.9 4.3 4.6.5-3.5 3.1 1 4.6L12 13.9 7.5 16l1-4.6L5 8.3l4.6-.5z"/>@break
@case('chat')<path d="M20 12a7 7 0 0 1-9.9 6.4L5 20l1.6-4.1A7 7 0 1 1 20 12z"/>@break
@case('settings')<circle cx="12" cy="12" r="3"/><path d="M19 12a7 7 0 0 0-.1-1.3l1.9-1.5-1.9-3.3-2.3.9a7 7 0 0 0-2.2-1.3L14 2h-4l-.4 2.2a7 7 0 0 0-2.2 1.3l-2.3-.9-1.9 3.3L5 9.7A7 7 0 0 0 5 12c0 .4 0 .9.1 1.3l-1.9 1.5 1.9 3.3 2.3-.9a7 7 0 0 0 2.2 1.3L10 22h4l.4-2.2a7 7 0 0 0 2.2-1.3l2.3.9 1.9-3.3-1.9-1.5c.1-.4.1-.9.1-1.3z"/>@break
@case('clients')<circle cx="9" cy="8" r="3.2"/><path d="M3.5 19a5.5 5.5 0 0 1 11 0"/><path d="M16 5.2a3.2 3.2 0 0 1 0 6"/><path d="M17.5 13.6A5.5 5.5 0 0 1 20.5 19"/>@break
@case('requests')<rect x="4" y="3.5" width="16" height="17" rx="2.2"/><path d="M8 8h8M8 12h8M8 16h5"/>@break
@case('bell')<path d="M6 9a6 6 0 1 1 12 0c0 5 2 6 2 6H4s2-1 2-6z"/><path d="M10 20a2 2 0 0 0 4 0"/>@break
@case('logout')<path d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/><path d="M16 16l4-4-4-4"/><path d="M20 12H10"/>@break
@case('plus')<path d="M12 5v14M5 12h14"/>@break
@case('arrow')<path d="M11 6l-6 6 6 6"/><path d="M5 12h14"/>@break
@case('sparkle')<path d="M12 4v16M4 12h16"/>@break
@case('image')<rect x="3.5" y="4.5" width="17" height="15" rx="2.2"/><circle cx="8.5" cy="9.5" r="1.6"/><path d="M4 17l4.5-4 3.5 3 3-2.5L20 17"/>@break
@case('menu')<path d="M4 6h16M4 12h16M4 18h16"/>@break
@case('check')<path d="M5 12.5 10 17l9-10"/>@break
@case('store')<path d="M4 9l1.2-4.2A1.5 1.5 0 0 1 6.6 3.5h10.8a1.5 1.5 0 0 1 1.4 1.3L20 9"/><path d="M4 9h16v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/><path d="M6 13v7h12v-7"/><path d="M10 20v-4h4v4"/>@break
@case('portfolio')<rect x="3.5" y="6" width="17" height="14" rx="2.2"/><path d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6"/><path d="M3.5 12h17"/>@break
@case('about')<circle cx="12" cy="12" r="9"/><path d="M12 11v5"/><circle cx="12" cy="7.7" r="1"/>@break
@case('cart')<circle cx="9" cy="20" r="1.4"/><circle cx="17" cy="20" r="1.4"/><path d="M3 4h2l2.2 11.2A1.5 1.5 0 0 0 8.7 16.4H18l2-8H6"/>@break
@case('heart')<path d="M12 20s-7-4.3-9.3-8.3C1.2 8.9 2.6 5.5 6 5.5c2 0 3.2 1.2 4 2.3.8-1.1 2-2.3 4-2.3 3.4 0 4.8 3.4 3.3 6.2C19 15.7 12 20 12 20z"/>@break
@case('star')<path d="M12 3.5l2.1 4.8 5.2.5-3.9 3.5 1.1 5.1L12 14.7l-4.5 2.7 1.1-5.1-3.9-3.5 5.2-.5z"/>@break
@endswitch
</svg>
