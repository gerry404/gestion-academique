import api, { ensureCsrfCookie } from '../api/client';
import type { LoginCredentials, User } from '../types/auth.types';

export const authService = {
  async login(credentials: LoginCredentials): Promise<User> {
    await ensureCsrfCookie();
    const { data } = await api.post<{ user: User }>('/api/login', credentials);
    return data.user;
  },

  async logout(): Promise<void> {
    await api.post('/api/logout');
  },

  async me(): Promise<User | null> {
    try {
      const { data } = await api.get<{ user: User }>('/api/me');
      return data.user;
    } catch {
      return null;
    }
  },
};
