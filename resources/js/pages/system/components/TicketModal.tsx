import { Ticket } from "@/types/system";
import { useDepartments } from "@/hooks/useDepartments";


interface TicketModalProps {
    ticket: Ticket | null;
    onClose: () => void;
}

// Mock de interações para visualização do "fórum"
const mockInteractions = [
    {
        id: 1,
        user: { name: "Suporte Técnico", department: "TI" },
        content: "Olá! Recebemos sua solicitação. O técnico responsável já foi notificado e entrará em contato em breve.",
        created_at: "2026-04-20T10:30:00Z",
        type: "response"
    },
    {
        id: 2,
        user: { name: "Nicolas", department: "Vendas" },
        content: "Obrigado! Preciso disso com certa urgência pois o sistema de pedidos está lento.",
        created_at: "2026-04-20T11:15:00Z",
        type: "user"
    },
    {
        id: 3,
        user: { name: "Admin", department: "Sistema" },
        content: "Status alterado para: Em Atendimento.",
        created_at: "2026-04-20T11:20:00Z",
        type: "system"
    }
];

export function TicketModal({ ticket, onClose }: TicketModalProps) {
    const { data: departments } = useDepartments();

    if (!ticket) return null;

    const departmentName = departments?.find(d => d.id === ticket.departmentId)?.name || 'Desconhecido';

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-8 font-sans overflow-hidden">
            {/* Backdrop */}
            <div 
                className="absolute inset-0 bg-slate-950/80 backdrop-blur-md transition-opacity" 
                onClick={onClose}
            ></div>

            {/* Modal Content - Grande (90% width/height) */}
            <div className="relative w-full max-w-7xl h-full max-h-[90vh] transform overflow-hidden rounded-[2.5rem] bg-slate-900 border border-white/10 shadow-[0_0_100px_rgba(0,0,0,0.5)] transition-all flex flex-col glass-panel animate-in fade-in zoom-in duration-300">
                
                {/* Top Glow/Line Decoration */}
                <div className="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-500 z-20"></div>

                {/* Header */}
                <header className="flex items-center justify-between px-10 py-6 border-b border-white/5 bg-slate-900/50 backdrop-blur-xl z-10">
                    <div className="flex items-center gap-4">
                        <div className="p-3 rounded-2xl bg-indigo-500/10 border border-indigo-500/20">
                            <svg className="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                        </div>
                        <div>
                            <div className="flex items-center gap-3">
                                <span className="text-[10px] text-indigo-400 font-bold uppercase tracking-[0.2em]">Ticket System</span>
                                <span className="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-[10px] text-slate-400 font-mono">#{ticket.id.toString().padStart(6, '0')}</span>
                            </div>
                            <h2 className="text-xl font-bold text-white tracking-tight">{ticket.title}</h2>
                        </div>
                    </div>
                    <button 
                        onClick={onClose}
                        className="p-3 rounded-full hover:bg-white/10 text-slate-400 hover:text-white transition-all border border-white/5 active:scale-95"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                {/* Main Body Layout */}
                <div className="flex-1 flex overflow-hidden">
                    
                    {/* Left Column: Interactions Feed (The "Forum") */}
                    <div className="flex-1 overflow-y-auto px-10 py-8 custom-scrollbar space-y-8 bg-slate-900/20">
                        
                        {/* Original Content / Opening Post */}
                        <div className="relative">
                            <div className="absolute left-[-1.5rem] top-0 bottom-0 w-px bg-slate-800"></div>
                            <div className="flex flex-col gap-4">
                                <div className="flex items-center gap-3">
                                    <div className="h-8 w-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold text-white">
                                        {ticket.creator?.name?.substring(0, 2).toUpperCase() || "??"}
                                    </div>
                                    <div className="flex flex-col">
                                        <span className="text-sm font-semibold text-white">{ticket.creator?.name || "Criador"}</span>
                                        <span className="text-[10px] text-slate-500 italic">Abriu este ticket em {new Date(ticket.createdAt).toLocaleString()}</span>
                                    </div>
                                </div>
                                <div className="p-6 rounded-3xl bg-slate-800/40 border border-white/5 text-slate-300 leading-relaxed shadow-inner">
                                    {ticket.description}
                                </div>
                            </div>
                        </div>

                        {/* Interactions Divider */}
                        <div className="flex items-center gap-4 py-4">
                            <div className="h-px flex-1 bg-slate-800"></div>
                            <span className="text-[10px] text-slate-600 font-bold uppercase tracking-widest">Interações</span>
                            <div className="h-px flex-1 bg-slate-800"></div>
                        </div>

                        {/* Forum Feed */}
                        {mockInteractions.map((msg) => (
                            <div key={msg.id} className="relative group">
                                <div className="absolute left-[-1.5rem] top-0 bottom-0 w-px bg-slate-800 group-last:h-4"></div>
                                <div className={`flex flex-col gap-4 ${msg.type === 'system' ? 'items-center py-2' : ''}`}>
                                    
                                    {msg.type !== 'system' && (
                                        <div className="flex items-center gap-3">
                                            <div className={`h-8 w-8 rounded-full ${msg.type === 'response' ? 'bg-indigo-500/20 text-indigo-400 border-indigo-500/20' : 'bg-emerald-500/20 text-emerald-400 border-emerald-500/20'} flex items-center justify-center text-xs font-bold border`}>
                                                {msg.user.name.substring(0, 2).toUpperCase()}
                                            </div>
                                            <div className="flex flex-col">
                                                <span className="text-sm font-semibold text-white">{msg.user.name}</span>
                                                <span className="text-[10px] text-slate-500">{msg.user.department} • {new Date(msg.created_at).toLocaleTimeString()}</span>
                                            </div>
                                        </div>
                                    )}

                                    {msg.type === 'system' ? (
                                        <div className="px-4 py-1.5 rounded-full bg-white/5 border border-white/5 text-[10px] text-slate-500 font-medium italic">
                                            {msg.content}
                                        </div>
                                    ) : (
                                        <div className={`p-5 rounded-2xl border ${msg.type === 'response' ? 'bg-indigo-500/5 border-indigo-500/10 text-indigo-100/90' : 'bg-slate-800/80 border-white/5 text-slate-300'} transition-all hover:border-white/10 shadow-sm`}>
                                            {msg.content}
                                        </div>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Right Column: Sidebar (Status & Info) */}
                    <aside className="overflow-y-auto w-80 border-l border-white/5 bg-slate-900/40 p-8 space-y-8 flex flex-col">
                        
                        {/* Status Management */}
                        <section>
                            <h3 className="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-4">Gerenciar Status</h3>
                            <div className="p-5 rounded-3xl bg-white/5 border border-white/5 space-y-4 shadow-inner">
                                <div className="flex items-center justify-between">
                                    <span className="text-xs text-slate-400">Status Atual:</span>
                                    <span className="px-2.5 py-1 rounded-lg bg-amber-500/10 text-amber-400 text-[10px] font-bold border border-amber-500/20 uppercase tracking-wider">Em Atendimento</span>
                                </div>
                                <div className="grid grid-cols-1 gap-2">
                                    <button className="w-full py-2.5 rounded-xl bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 text-[10px] font-bold border border-blue-500/20 transition-all active:scale-95">Pendente</button>
                                    <button className="w-full py-2.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 text-[10px] font-bold border border-amber-500/20 transition-all active:scale-95">Em Atendimento</button>
                                    <button className="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-bold transition-all shadow-lg shadow-emerald-500/20 active:scale-95">Finalizar Ticket</button>
                                </div>
                            </div>
                        </section>

                        {/* Details */}
                        <section className="space-y-6 flex-1">
                            <h3 className="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-4">Informações</h3>
                            <div className="space-y-5">
                                <div className="flex flex-col gap-1.5 p-4 rounded-2xl bg-white/5 border border-white/5">
                                    <span className="text-[10px] text-slate-500 uppercase tracking-tighter">Solicitante</span>
                                    <span className="text-sm font-semibold text-slate-100">{ticket.creator?.name || 'Desconhecido'}</span>
                                    <span className="text-[10px] text-slate-500">{ticket.creator?.email || 'Sem email'}</span>
                                </div>
                                <div className="flex flex-col gap-1.5 p-4 rounded-2xl bg-white/5 border border-white/5">
                                    <span className="text-[10px] text-slate-500 uppercase tracking-tighter">Departamento Alvo</span>
                                    <span className="text-sm font-semibold text-indigo-400">{departmentName}</span>
                                </div>
                            </div>
                        </section>

                        {/* Danger Zone */}
                        <section className="pt-4 border-t border-white/5">
                            <button className="w-full py-2.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-500 text-[10px] font-bold border border-red-500/20 transition-all opacity-50 hover:opacity-100">
                                Excluir Ticket
                            </button>
                        </section>

                    </aside>
                </div>

                {/* Footer: Response Input */}
                <footer className="px-10 py-6 border-t border-white/5 bg-slate-900/80 backdrop-blur-xl">
                    <div className="relative group">
                        <textarea 
                            placeholder="Digite aqui para interagir com o solicitante..." 
                            className="w-full p-5 pr-36 rounded-[2rem] bg-white/5 border border-white/10 text-slate-200 focus:outline-none focus:border-indigo-500/50 transition-all min-h-[80px] max-h-[200px] resize-none scrollbar-hide text-sm"
                        ></textarea>
                        <div className="absolute top-1/2 -translate-y-1/2 right-3 flex items-center gap-2">
                            <button className="px-8 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold transition-all shadow-xl shadow-indigo-600/30 active:scale-95 group-focus-within:ring-2 ring-indigo-500/50">
                                Enviar
                            </button>
                        </div>
                    </div>
                </footer>

            </div>
        </div>
    );
}