import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'api/api_client.dart';
import 'providers/auth_provider.dart';
import 'providers/etudiant_provider.dart';
import 'providers/matiere_provider.dart';
import 'providers/note_provider.dart';
import 'providers/user_provider.dart';
import 'routes/app_router.dart';
import 'services/auth_service.dart';
import 'services/etudiant_service.dart';
import 'services/matiere_service.dart';
import 'services/note_service.dart';
import 'services/token_storage.dart';
import 'services/user_service.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  final tokenStorage = TokenStorage();
  final api = await ApiClient.init(tokenStorage);
  runApp(
    GestionScolaireApp(
      authService: AuthService(api, tokenStorage),
      etudiantService: EtudiantService(api),
      userService: UserService(api),
      matiereService: MatiereService(api),
      noteService: NoteService(api),
    ),
  );
}

class GestionScolaireApp extends StatelessWidget {
  const GestionScolaireApp({
    super.key,
    required this.authService,
    required this.etudiantService,
    required this.userService,
    required this.matiereService,
    required this.noteService,
  });

  final AuthService authService;
  final EtudiantService etudiantService;
  final UserService userService;
  final MatiereService matiereService;
  final NoteService noteService;

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => AuthProvider(authService)),
        ChangeNotifierProvider(create: (_) => EtudiantProvider(etudiantService)),
        ChangeNotifierProvider(create: (_) => UserProvider(userService)),
        ChangeNotifierProvider(create: (_) => MatiereProvider(matiereService)),
        ChangeNotifierProvider(create: (_) => NoteProvider(noteService)),
      ],
      child: Builder(
        builder: (context) {
          final router = createRouter(context.read<AuthProvider>());
          return MaterialApp.router(
            title: 'Gestion Scolaire',
            debugShowCheckedModeBanner: false,
            theme: ThemeData(
              useMaterial3: true,
              colorSchemeSeed: const Color(0xFF2563EB),
              scaffoldBackgroundColor: const Color(0xFFF8FAFC),
            ),
            routerConfig: router,
          );
        },
      ),
    );
  }
}
