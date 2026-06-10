import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';

import 'package:gestion_scolaire/pages/login_page.dart';

void main() {
  testWidgets('La page de connexion affiche le formulaire', (tester) async {
    await tester.pumpWidget(const MaterialApp(home: LoginPage()));

    expect(find.text('Gestion Scolaire'), findsOneWidget);
    expect(find.text('Se connecter'), findsOneWidget);
    expect(find.text('Se souvenir de moi'), findsOneWidget);
  });
}
