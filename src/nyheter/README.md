# Nyheter

Publik visning av nyheter använder:

- `/nyheter/` för listning, filtrering, sökning och pagination
- `/nyheter/post.php?slug=<slug>` för enskild post
- `/api/posts.php` för JSON-data

Datakälla:

- Sätt `RR_POSTS_JSON_PATH` till en JSON-fil från admin-systemet
- Om ingen datakälla finns används fallback-poster för att hålla sidan fungerande
