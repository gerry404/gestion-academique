import { Outlet } from 'react-router-dom';
import { useAuth } from '../../hooks/useAuth';

export default function DashboardLayout() {
  const { user, logout } = useAuth();

  return (
    <div className="flex min-h-screen bg-slate-50">
      {/* Sidebar */}
      <aside className="w-64 shrink-0 border-r border-slate-200 bg-white p-4">
        <div className="mb-6 px-2">
          <h2 className="text-lg font-bold text-slate-800">Gestion Scolaire</h2>
          <p className="text-xs text-slate-500">Tableau de bord</p>
        </div>

        <nav className="space-y-1 text-sm">
          <NavItem label="Accueil" active />
          <NavItem label="Etablissement" />
          <NavItem label="Etudiants" />
          <NavItem label="Notes" />
          <NavItem label="Effets academiques" />
          <NavItem label="Statistiques" />
          <NavItem label="Administration" />
        </nav>
      </aside>

      {/* Main */}
      <div className="flex flex-1 flex-col">
        {/* Topbar */}
        <header className="flex items-center justify-between border-b border-slate-200 bg-white px-6 py-3">
          <div className="text-sm text-slate-500">
            Connecte en tant que <span className="font-medium text-slate-800">{user?.name}</span>
            <span className="ml-2 rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">
              {user?.role}
            </span>
          </div>
          <button
            onClick={() => void logout()}
            className="rounded-lg bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700 transition hover:bg-red-100"
          >
            Deconnexion
          </button>
        </header>

        {/* Contenu */}
        <main className="flex-1 p-6">
          <Outlet />
        </main>
      </div>
    </div>
  );
}

function NavItem({ label, active = false }: { label: string; active?: boolean }) {
  return (
    <a
      href="#"
      className={`block rounded-lg px-3 py-2 transition ${
        active ? 'bg-blue-50 font-medium text-blue-700' : 'text-slate-600 hover:bg-slate-100'
      }`}
    >
      {label}
    </a>
  );
}
