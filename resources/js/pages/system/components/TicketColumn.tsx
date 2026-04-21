import React, { FormEvent } from 'react';
import { useForm } from '@inertiajs/react';
import { Department, Ticket, User } from '@/types/system';
import { useDepartments } from '@/hooks/useDepartments';

interface TicketColumnProps {
    tickets: Ticket[];
    users: User[];
    activeUser: User | null;
    onSubmit: (title: string, desc: string, targetDeptId: number) => Promise<void>;
    onTicketClick: (ticket: Ticket) => void;
}

export function TicketColumn({ tickets, users, activeUser, onSubmit, onTicketClick }: TicketColumnProps) {
    const { data: serverDepartments } = useDepartments();
    
    const { data, setData, reset, processing } = useForm({
        title: '',
        description: '',
        department_id: ''
    });

    const handleSubmit = async (e: FormEvent) => {
        e.preventDefault();
        
        if (!activeUser) {
            alert('Faça login com um usuário primeiro!');
            return;
        }

        try {
            await onSubmit(data.title, data.description, Number(data.department_id));
            reset();
        } catch (error) {
            console.error("Erro ao abrir ticket, mantendo formulário.");
        }
    };

    return (
        <section className="flex flex-col gap-6">
            <div className="glass-panel rounded-2xl p-5 border-t border-emerald-500/30 relative overflow-hidden group">
                
                {/* Overlay quando não está logado */}
                {!activeUser && (
                    <div className="absolute inset-0 bg-slate-900/80 backdrop-blur-[2px] z-10 flex flex-col items-center justify-center transition-opacity">
                        <svg className="w-10 h-10 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <p className="text-sm text-slate-300 font-medium text-center px-4 leading-relaxed">
                            Selecione um usuário na coluna ao lado para fazer <br/>"login" e abrir tickets.
                        </p>
                    </div>
                )}

                <div className="flex items-center gap-2 mb-4">
                    <svg className="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h2 className="text-lg font-semibold text-white">Abrir Novo Ticket</h2>
                </div>
                
                <form className="space-y-4" onSubmit={handleSubmit}>
                    <div>
                        <input 
                            type="text" 
                            required 
                            placeholder="Assunto do Ticket" 
                            className="w-full px-4 py-2.5 rounded-xl input-stylish text-sm"
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                            disabled={!activeUser}
                        />
                    </div>
                    <div>
                        <textarea 
                            required 
                            rows={2} 
                            placeholder="Descrição ou conteúdo do chamado..." 
                            className="w-full px-4 py-2.5 rounded-xl input-stylish text-sm resize-none"
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                            disabled={!activeUser}
                        ></textarea>
                    </div>
                    <div>
                        <select 
                            required 
                            className="w-full px-4 py-2.5 rounded-xl input-stylish text-sm appearance-none"
                            value={data.department_id}
                            onChange={(e) => setData('department_id', e.target.value)}
                            disabled={!activeUser}
                        >
                            <option value="" disabled>Departamento de Destino...</option>
                            {serverDepartments?.map((d) => (
                                <option key={d.id} value={d.id}>{d.name}</option>
                            ))}
                        </select>
                    </div>
                    <button 
                        type="submit" 
                        disabled={processing || !activeUser || serverDepartments?.length === 0}
                        className="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium transition-all shadow-lg shadow-emerald-600/20 active:scale-[0.98] disabled:opacity-50"
                    >
                        {processing ? 'Criando Ticket...' : 'Criar Ticket'}
                    </button>
                </form>
            </div>

            <div className="glass-panel rounded-2xl p-5 flex-1 flex flex-col">
                <h3 className="text-sm font-medium text-slate-400 mb-3 uppercase tracking-wider">Tickets Abertos</h3>
                
                <div className="space-y-3 overflow-y-auto max-h-[400px] flex-1">
                    {tickets.length === 0 ? (
                        <p className="text-slate-500 text-sm italic py-4 text-center border border-dashed border-slate-700 rounded-xl">
                            Ainda não há tickets registrados no sistema.
                        </p>
                    ) : (
                        tickets.map(t => {
                            const creator = t.creator || users.find(u => u.id === t.requesterId);
                            const deptName = serverDepartments?.find(d => d.id === t.departmentId)?.name 
                                           || 'Desconhecido';

                            return (
                                <div onClick={() => onTicketClick(t)} key={t.id} className="p-4 rounded-xl bg-slate-800/80 border border-slate-700/50 flex flex-col gap-2 relative overflow-hidden group hover:border-emerald-500/30 transition-colors">
                                    <div className="absolute top-0 right-0 px-2 py-1 bg-emerald-500/20 rounded-bl-xl border-b border-l border-emerald-500/20 text-[10px] text-emerald-400 font-bold uppercase tracking-wider shadow-sm">
                                        TKT-#{t.id.toString().padStart(4, '0')}
                                    </div>
                                    
                                    <div>
                                        <h4 className="text-slate-100 font-semibold text-sm mr-16">{t.title}</h4>
                                        <p className="text-slate-400 text-xs mt-1 line-clamp-2">{t.description}</p>
                                    </div>
                                    
                                    <div className="flex items-center justify-between mt-2 pt-3 border-t border-slate-700/50">
                                        <div className="flex items-center gap-2">
                                            <div className="h-6 w-6 rounded-full bg-slate-600 flex items-center justify-center text-[10px] text-white font-medium uppercase border border-slate-500">
                                                {creator?.name?.substring(0, 2) || '??'}
                                            </div>
                                            <div className="flex flex-col">
                                                <span className="text-[10px] text-slate-500 leading-none">Aberto por:</span>
                                                <span className="text-xs text-slate-300 font-medium leading-none mt-1">{creator?.name || 'Desconhecido'}</span>
                                            </div>
                                        </div>
                                        <div className="flex flex-col items-end">
                                            <span className="text-[10px] text-slate-500 leading-none">Para Depto:</span>
                                            <span className="text-xs text-indigo-400 font-medium leading-none mt-1 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/10">
                                                {deptName}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            );
                        })
                    )}
                </div>
            </div>
        </section>
    );
}
