import { User, Department } from '@/types/system';
import { Head } from '@inertiajs/react';

interface TopHeaderProps {
    activeUser: User | null;
    activeDepartment: Department | null;
}

export function TopHeader({ activeUser, activeDepartment }: TopHeaderProps) {
    return (
        <header className="glass-panel sticky top-0 z-50 px-6 py-4 flex items-center justify-between border-b border-slate-700/50">
            <Head title="Ticket System - Arquitetura" />
            
            <div className="flex items-center gap-3">
                <div className="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <div>
                    <h1 className="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">
                        CleanTicket DDD
                    </h1>
                    <p className="text-xs text-slate-400 font-medium tracking-wide border-t border-transparent uppercase">Simulate Environment</p>
                </div>
            </div>

            <div className="flex items-center gap-4">
                {activeDepartment && (
                    <div className="ml-8 px-3 py-1 rounded-md bg-indigo-500/10 border border-indigo-500/20 flex items-center gap-2">
                        <div className="h-2 w-2 rounded-full bg-indigo-400 animate-pulse"></div>
                        <span className="text-xs font-semibold text-indigo-300 uppercase tracking-wider">
                            Departamento: {activeDepartment.name}
                        </span>
                    </div>
                )}
                
                {activeUser ? (
                    <div className="flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium">
                        <span className="relative flex h-2.5 w-2.5">
                            <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span className="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        Logado como: <span className="font-bold text-white">{activeUser.name}</span>
                    </div>
                ) : (
                    <div className="flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800/80 border border-slate-700/50 text-slate-400 text-sm font-medium">
                        <div className="h-2 w-2 rounded-full bg-slate-600"></div>
                        Nenhum usuário logado
                    </div>
                )}
            </div>
        </header>
    );
}
