import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../providers/auth_provider.dart';

class DashboardPage extends StatelessWidget {
  const DashboardPage({super.key});

  static const _modules = <_Module>[
    _Module(
      titre: "Gestion de l'etablissement",
      desc: 'Annees, departements, specialites, niveaux, UE, matieres',
      couleur: Color(0xFF3B82F6),
    ),
    _Module(
      titre: 'Gestion des etudiants',
      desc: 'Liste, inscription, infos etudiants',
      couleur: Color(0xFF10B981),
    ),
    _Module(
      titre: 'Gestion des notes',
      desc: 'Attribution des notes CC et SN par matiere',
      couleur: Color(0xFFF59E0B),
    ),
    _Module(
      titre: 'Effets academiques',
      desc: 'Cartes, certificats, releves de notes (PDF)',
      couleur: Color(0xFFA855F7),
    ),
    _Module(
      titre: 'Statistiques',
      desc: 'Taux de reussite, effectifs, moyennes',
      couleur: Color(0xFFF43F5E),
    ),
    _Module(
      titre: 'Administration',
      desc: 'Utilisateurs, roles et permissions',
      couleur: Color(0xFF334155),
    ),
  ];

  @override
  Widget build(BuildContext context) {
    final user = context.watch<AuthProvider>().user;

    return SingleChildScrollView(
      padding: const EdgeInsets.all(24),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Bonjour ${user?.name ?? ''} 👋',
            style: const TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
              color: Color(0xFF1E293B),
            ),
          ),
          const SizedBox(height: 4),
          const Text(
            "Bienvenue dans l'application de gestion scolaire.",
            style: TextStyle(color: Color(0xFF64748B)),
          ),
          const SizedBox(height: 24),
          LayoutBuilder(
            builder: (context, constraints) {
              final crossAxisCount = constraints.maxWidth >= 1024
                  ? 3
                  : constraints.maxWidth >= 640
                      ? 2
                      : 1;
              return GridView.builder(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                itemCount: _modules.length,
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: crossAxisCount,
                  mainAxisSpacing: 16,
                  crossAxisSpacing: 16,
                  mainAxisExtent: 150,
                ),
                itemBuilder: (context, index) =>
                    _ModuleCard(module: _modules[index]),
              );
            },
          ),
        ],
      ),
    );
  }
}

class _Module {
  const _Module({
    required this.titre,
    required this.desc,
    required this.couleur,
  });

  final String titre;
  final String desc;
  final Color couleur;
}

class _ModuleCard extends StatelessWidget {
  const _ModuleCard({required this.module});

  final _Module module;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: const Color(0xFFE2E8F0)),
        boxShadow: const [
          BoxShadow(
            color: Color(0x0F000000),
            blurRadius: 4,
            offset: Offset(0, 1),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            width: 48,
            height: 8,
            decoration: BoxDecoration(
              color: module.couleur,
              borderRadius: BorderRadius.circular(999),
            ),
          ),
          const SizedBox(height: 12),
          Text(
            module.titre,
            style: const TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.w600,
              color: Color(0xFF1E293B),
            ),
          ),
          const SizedBox(height: 4),
          Text(
            module.desc,
            style: const TextStyle(fontSize: 14, color: Color(0xFF64748B)),
          ),
          const Spacer(),
          const Text(
            'A implementer',
            style: TextStyle(
              fontSize: 12,
              fontStyle: FontStyle.italic,
              color: Color(0xFF94A3B8),
            ),
          ),
        ],
      ),
    );
  }
}
