import React, { FormEvent } from 'react';
import { useForm } from '@inertiajs/react';
import { Department, User } from '@/types/system';

interface UserColumnProps {
    users: User[];
    departments: Department[];
    activeUser: User | null;
    onUserLogin: (user: User) => void;
    onSubmitMock?: (name: string, departmentId: number) => void;
}

export function UserColumn({ users, departments, activeUser, onUserLogin, onSubmitMock }: UserColumnProps) {
    const { data, setData, post, reset, processing } = useForm({
        name: '',
        department_id: ''
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        
        if (onSubmitMock) {
            onSubmitMock(data.name, Number(data.department_id));
            reset();
            return;
        }

        // Caso exista rota backend real mapeada:
        post('/users', {
            onSuccess: () => reset(),
        });
    };

    return (
        <section className="flex flex-col gap-6">
            <div className="glass-panel rounded-2xl p-5 border-t border-purple-500/30">
                <div className="flex items-center gap-2 mb-4">
                    <svg className="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <h2 className="text-lg font-semibold text-white">Adicionar Usuário</h2>
                </div>
                
                <form className="space-y-4" onSubmit={handleSubmit}>
                    <div>
                        <input 
                            type="text" 
                            required 
                            placeholder="Nome do Usuário" 
                            className="w-full px-4 py-2.5 rounded-xl input-stylish text-sm"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                        />
                    </div>
                    <div>
                        <select 
                            required 
                            className="w-full px-4 py-2.5 rounded-xl input-stylish text-sm appearance-none"
                            value={data.department_id}
                            onChange={(e) => setData('department_id', e.target.value)}
                        >
                            <option value="" disabled>Vincular a um Departamento...</option>
                            {departments.map((d) => (
                                <option key={d.id} value={d.id}>{d.name}</option>
                            ))}
                        </select>
                    </div>
                    <button 
                        type="submit" 
                        disabled={processing || departments.length === 0}
                        className="w-full py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-sm font-medium transition-all shadow-lg shadow-purple-600/20 active:scale-[0.98] disabled:opacity-50"
                    >
                        {processing ? 'Cadastrando...' : 'Cadastrar Usuário'}
                    </button>
                </form>
            </div>

            <div className="glass-panel rounded-2xl p-5 flex-1 flex flex-col">
                <h3 className="text-sm font-medium text-slate-400 mb-3 uppercase tracking-wider">Lista de Usuários (Clique para Logar)</h3>
                
                <div className="space-y-2 overflow-y-auto max-h-[400px] flex-1">
                    {users.length === 0 ? (
                        <p className="text-slate-500 text-sm italic py-4 text-center border border-dashed border-slate-700 rounded-xl">
                            Nenhum usuário cadastrado.
                        </p>
                    ) : (
                        users.map(u => {
                            const isActive = activeUser?.id === u.id;
                            // Assumindo que o back-end irá enviar o relation `department` ou apenas cuidaremos dele aqui
                            const currentDept = u.department || departments.find(d => d.id === u.department_id);

                            return (
                                <button 
                                    key={u.id}
                                    onClick={() => onUserLogin(u)}
                                    className={`w-full text-left flex items-center gap-3 p-3 rounded-xl bg-slate-800/80 border transition-all group ${
                                        isActive 
                                        ? 'ring-2 ring-purple-500 border-purple-500 bg-slate-700/80 shadow-md shadow-purple-500/20' 
                                        : 'border-slate-700/50 hover:bg-slate-700/80 hover:border-purple-500/50'
                                    }`}
                                >
                                    <div className="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold uppercase shrink-0">
                                        {u.name.substring(0, 2)}
                                    </div>
                                    <div className="flex-1 overflow-hidden">
                                        <div className="text-slate-200 font-medium text-sm truncate">{u.name}</div>
                                        <div className="text-xs text-slate-400 truncate">{currentDept?.name || 'Desconhecido'}</div>
                                    </div>
                                    <div className={`text-xs font-medium transition-opacity ${isActive ? 'text-purple-300 opacity-100' : 'text-purple-400 opacity-0 group-hover:opacity-100'}`}>
                                        {isActive ? 'Ativo' : 'Logar'}
                                    </div>
                                </button>
                            );
                        })
                    )}
                </div>
            </div>
        </section>
    );
}
