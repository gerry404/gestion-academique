import { useAuth } from '../hooks/useAuth';

const modules = [
  { titre: "Gestion de l'etablissement", desc: 'Annees, departements, specialites, niveaux, UE, matieres', couleur: 'bg-blue-500' },
  { titre: 'Gestion des etudiants', desc: 'Liste, inscription, infos etudiants', couleur: 'bg-emerald-500' },
  { titre: 'Gestion des notes', desc: 'Attribution des notes CC et SN par matiere', couleur: 'bg-amber-500' },
  { titre: 'Effets academiques', desc: 'Cartes, certificats, releves de notes (PDF)', couleur: 'bg-purple-500' },
  { titre: 'Statistiques', desc: "Taux de reussite, effectifs, moyennes", couleur: 'bg-rose-500' },
  { titre: 'Administration', desc: 'Utilisateurs, roles et permissions', couleur: 'bg-slate-700' },
];

export default function DashboardPage() {
  const { user } = useAuth();

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-2xl font-bold text-slate-800">
          Bonjour {user?.name} 👋
        </h1>
        <p className="text-slate-500">Bienvenue dans l'application de gestion scolaire.</p>
      </div>

      <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {modules.map((mod) => (
          <div
            key={mod.titre}
            className="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md"
          >
            <div className={`mb-3 h-2 w-12 rounded-full ${mod.couleur}`} />
            <h2 className="text-lg font-semibold text-slate-800">{mod.titre}</h2>
            <p className="mt-1 text-sm text-slate-500">{mod.desc}</p>
            <p className="mt-3 text-xs italic text-slate-400">A implementer</p>
          </div>
        ))}
      </div>
    </div>
  );
}
