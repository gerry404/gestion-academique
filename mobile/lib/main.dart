import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'api/api_client.dart';
import 'providers/auth_provider.dart';
import 'routes/app_router.dart';
import 'services/auth_service.dart';
import 'services/token_storage.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  final tokenStorage = TokenStorage();
  final api = await ApiClient.init(tokenStorage);
  runApp(GestionScolaireApp(authService: AuthService(api, tokenStorage)));
}

class GestionScolaireApp extends StatelessWidget {
  const GestionScolaireApp({super.key, required this.authService});

  final AuthService authService;

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (_) => AuthProvider(authService),
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
