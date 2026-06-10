import axios from 'axios';

/**
 * Client axios partage pour toutes les requetes API.
 *
 * - baseURL: URL du backend Laravel (configurable via VITE_API_URL)
 * - withCredentials: true => indispensable pour que Sanctum envoie/recoit
 *   le cookie de session entre le frontend (5173) et le backend (8000)
 */
const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? 'http://localhost:8000',
  withCredentials: true,
  headers: {
    Accept: 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
});

/**
 * Avant chaque mutation (POST/PUT/DELETE), Sanctum exige de recuperer
 * d'abord un cookie CSRF via /sanctum/csrf-cookie.
 * Cette fonction est utilisee une fois au demarrage et avant le login.
 */
export async function ensureCsrfCookie(): Promise<void> {
  await api.get('/sanctum/csrf-cookie');
}

export default api;
