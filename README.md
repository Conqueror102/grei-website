# GREI Group website

Laravel 13 site for GREI Group (Global Real Estate & Interior Design): Home, Real Estate, Interiors, Stays, About and Contact.

## Run it locally

Needs PHP 8.3+, Composer and Node 20+.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build        # or `npm run dev` while editing
php artisan serve    # http://127.0.0.1:8000
php artisan test     # 7 feature tests
```

## Where things live

| What | Where |
| --- | --- |
| Design (ported 1:1 from the Zenith template) | Blade components in `resources/views/components` use Zenith's exact classes: `#111111` ink, `#F5F5F5` sections, `#EAEAEA` hairlines, DM Sans |
| Contact details, currency, page images | `config/grei.php` (or `GREI_*` values in `.env`) |
| Sample properties, projects, stays | `database/seeders/data/*.php` (placeholders, replace with real content) |
| Pages | `resources/views/{pages,real-estate,interiors,stays}` |
| Shared pieces (header, footer, cards, forms) | `resources/views/components` |
| Logo | `public/images/brand/grei-mark-dark-tight.png` (navbar/footer), `grei-mark-light-*` for dark backgrounds |
| Dither mountain footer | `resources/js/ridgeline.ts` + `resources/css/ridgeline.css` (Zenith's footer, without React) |

Icons are Phosphor duotone (`@phosphor-icons/web`): `<i class="ph-duotone ph-house"></i>`. Browse names at phosphoricons.com.

Real-estate photos are Zenith's own images, served from `public/images/photos`. Interiors and stays photos are free Unsplash photos (Unsplash License), referenced by photo id and served from Unsplash's CDN. To swap one, change the id in `config/grei.php` or a seeder, or put a file in `public/images/` and use its path instead (`'images/my-photo.jpg'`). If an Unsplash photo fails to load, one of the local photos is shown in its place.

## Enquiries and stays bookings

All forms save to the `enquiries` table and email `GREI_ENQUIRIES_TO` (mail goes to the log until `MAIL_*` is configured).

Stays currently run **by request**: guests choose dates, see an estimate, and the team confirms availability and payment. The booking logic sits behind `App\Contracts\StayBookingProvider`, implemented today by `App\Services\Booking\EnquiryBookingProvider`. To move to instant booking, write a provider for the chosen booking engine or channel manager and change the binding in `App\Providers\AppServiceProvider`. The pages switch their wording to "Book now" automatically when `mode()` returns `instant`.

## Not built yet

- An admin area to manage listings and read enquiries (Filament is a good fit).
- Real content, photography and contact details.
- Payment, if instant booking is chosen.
