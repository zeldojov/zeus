import Alpine from 'alpinejs';
import anchor from '@alpinejs/anchor';
import collapse from '@alpinejs/collapse';
import focus from '@alpinejs/focus';
import intersect from '@alpinejs/intersect';
import mask from '@alpinejs/mask';
import morph from '@alpinejs/morph';
import persist from '@alpinejs/persist';
import resize from '@alpinejs/resize';
import sort from '@alpinejs/sort';

window.Alpine = Alpine;

Alpine.plugin([anchor, collapse, focus, intersect, mask, morph, persist, resize, sort]);
Alpine.start();
