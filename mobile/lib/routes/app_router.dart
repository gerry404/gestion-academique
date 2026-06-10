import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import '../components/layout/dashboard_layout.dart';
import '../pages/dashboard_page.dart';
import '../pages/login_page.dart';
import '../providers/auth_provider.dart';

GoRouter createRouter(AuthProvider auth) {
  return GoRouter(
    initialLocation: '/',
    refreshListenable: auth,
    redirect: (context, state) {
      final location = state.matchedLocation;

      if (auth.isLoading) {
        return location == '/splash' ? null : '/splash';
      }

      if (location == '/splash') {
        return auth.isAuthenticated ? '/' : '/login';
      }

      if (!auth.isAuthenticated && location != '/login') {
        return '/login';
      }
      if (auth.isAuthenticated && location == '/login') {
        return '/';
      }
      return null;
    },
    routes: [
      GoRoute(
        path: '/splash',
        builder: (context, state) => const _SplashPage(),
      ),
      GoRoute(
        path: '/login',
        builder: (context, state) => const LoginPage(),
      ),
      ShellRoute(
        builder: (context, state, child) => DashboardLayout(child: child),
        routes: [
          GoRoute(
            path: '/',
            builder: (context, state) => const DashboardPage(),
          ),
        ],
      ),
    ],
  );
}

class _SplashPage extends StatelessWidget {
  const _SplashPage();

  @override
  Widget build(BuildContext context) {
    return const Scaffold(
      backgroundColor: Color(0xFFF8FAFC),
      body: Center(
        child: Text(
          'Chargement...',
          style: TextStyle(color: Color(0xFF64748B)),
        ),
      ),
    );
  }
}
