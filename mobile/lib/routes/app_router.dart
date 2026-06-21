import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import '../components/layout/dashboard_layout.dart';
import '../models/etudiant.dart';
import '../models/matiere.dart';
import '../models/note.dart';
import '../models/user.dart';
import '../pages/administration/administration_page.dart';
import '../pages/administration/user_form_page.dart';
import '../pages/dashboard_page.dart';
import '../pages/etablissement/etablissement_page.dart';
import '../pages/etablissement/matiere_form_page.dart';
import '../pages/etudiants/etudiant_form_page.dart';
import '../pages/etudiants/etudiants_page.dart';
import '../pages/login_page.dart';
import '../pages/notes/note_form_page.dart';
import '../pages/notes/notes_page.dart';
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
          GoRoute(
            path: '/etudiants',
            builder: (context, state) => const EtudiantsPage(),
          ),
          GoRoute(
            path: '/etablissement',
            builder: (context, state) => const EtablissementPage(),
          ),
          GoRoute(
            path: '/notes',
            builder: (context, state) => const NotesPage(),
          ),
          GoRoute(
            path: '/administration',
            builder: (context, state) => const AdministrationPage(),
          ),
        ],
      ),
      GoRoute(
        path: '/etudiants/form',
        builder: (context, state) =>
            EtudiantFormPage(etudiant: state.extra as Etudiant?),
      ),
      GoRoute(
        path: '/etablissement/form',
        builder: (context, state) =>
            MatiereFormPage(matiere: state.extra as Matiere?),
      ),
      GoRoute(
        path: '/notes/form',
        builder: (context, state) => NoteFormPage(note: state.extra as Note?),
      ),
      GoRoute(
        path: '/administration/form',
        builder: (context, state) =>
            UserFormPage(user: state.extra as User?),
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
