import './bootstrap';
import Alpine from 'alpinejs';
import '../css/app.css';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const sidebarToggle = document.getElementById('sidebarToggle');
    const themeToggle = document.getElementById('themeToggle');
    const profileToggle = document.getElementById('profileMenuToggle');
    const profileMenu = document.querySelector('.profile-menu');
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationMenu = document.querySelector('.notification-menu');

    const isMobile = () => window.matchMedia('(max-width: 992px)').matches;

    sidebarToggle?.addEventListener('click', () => {
        if (isMobile()) {
            body.classList.toggle('sidebar-open');
            sidebarToggle.setAttribute(
                'aria-expanded',
                String(body.classList.contains('sidebar-open'))
            );
            return;
        }

        body.classList.toggle('sidebar-collapsed');
        sidebarToggle.setAttribute(
            'aria-expanded',
            String(!body.classList.contains('sidebar-collapsed'))
        );
    });

    const setTheme = (dark) => {
        body.classList.toggle('dark-mode', dark);

        const icon = themeToggle?.querySelector('i');
        icon?.classList.toggle('bi-moon-stars', !dark);
        icon?.classList.toggle('bi-sun', dark);

        localStorage.setItem('kwetu-theme', dark ? 'dark' : 'light');
    };

    setTheme(localStorage.getItem('kwetu-theme') === 'dark');

    themeToggle?.addEventListener('click', () => {
        setTheme(!body.classList.contains('dark-mode'));
    });

    profileToggle?.addEventListener('click', () => {
        profileMenu?.classList.toggle('open');
        profileToggle.setAttribute(
            'aria-expanded',
            String(profileMenu?.classList.contains('open'))
        );
    });

    notificationToggle?.addEventListener('click', () => {
        notificationMenu?.classList.toggle('open');
        notificationToggle.setAttribute('aria-expanded', String(notificationMenu?.classList.contains('open')));
    });

    document.addEventListener('click', (event) => {
        if (profileMenu && !profileMenu.contains(event.target)) {
            profileMenu.classList.remove('open');
            profileToggle?.setAttribute('aria-expanded', 'false');
        }
        if (notificationMenu && !notificationMenu.contains(event.target)) {
            notificationMenu.classList.remove('open');
            notificationToggle?.setAttribute('aria-expanded', 'false');
        }
    });

    const routePlanner = document.getElementById('routePlanner');
    const routeResult = document.getElementById('routeResult');
    routePlanner?.addEventListener('click', () => {
        if (!navigator.geolocation) {
            routeResult.textContent = 'Location is not available in this browser. You can still use the map above to find the residence.';
            return;
        }
        routeResult.textContent = 'Finding the best route from your current location…';
        routePlanner.disabled = true;
        navigator.geolocation.getCurrentPosition(async ({ coords }) => {
            const destination = [routePlanner.dataset.lng, routePlanner.dataset.lat].join(',');
            const origin = [coords.longitude, coords.latitude].join(',');
            try {
                const response = await fetch('https://router.project-osrm.org/route/v1/driving/' + origin + ';' + destination + '?overview=false');
                const data = await response.json();
                const route = data.routes?.[0];
                if (!route) throw new Error('No route');
                const distance = (route.distance / 1000).toFixed(1);
                const minutes = Math.max(1, Math.round(route.duration / 60));
                routeResult.innerHTML = '<strong>Your route is ready.</strong><br>About ' + distance + ' km · approximately ' + minutes + ' minutes by car.';
            } catch {
                routeResult.textContent = 'Your location was found, but travel time is unavailable right now. Please use the map above to plan your trip.';
            } finally {
                routePlanner.disabled = false;
            }
        }, () => {
            routeResult.textContent = 'We could not access your location. Allow location access in your browser, then try again.';
            routePlanner.disabled = false;
        }, { enableHighAccuracy: false, timeout: 8000, maximumAge: 300000 });
    });
});
