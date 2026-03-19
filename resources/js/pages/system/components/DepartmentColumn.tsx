import React, { FormEvent } from 'react';
import { useForm } from '@inertiajs/react';
import { Department } from '@/types/system';

interface DepartmentColumnProps {
    departments: Department[];
    onSubmit?: (name: string) => void;
    onDepartmentClick?: (departmentId: number) => void;
}

export function DepartmentColumn({ departments, onSubmit, onDepartmentClick }: DepartmentColumnProps) {
    const { data, setData, post, reset, processing } = useForm({
        name: ''
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        
        if (onSubmit) {
            onSubmit(data.name);
            reset();
            return;
        }

        // Caso exista rota backend real mapeada:
        post('/departments', {
            onSuccess: () => reset(),
        });
    };

    return (
        <section className="flex flex-col gap-6">
            <div className="glass-panel rounded-2xl p-5 border-t border-indigo-500/30">
                <div className="flex items-center gap-2 mb-4">
                    <svg className="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h2 className="text-lg font-semibold text-white">Adicionar Departamento</h2>
                </div>
                
                <form className="space-y-4" onSubmit={handleSubmit}>
                    <div>
                        <input 
                            type="text" 
                            required 
                            placeholder="Ex: Suporte T.I" 
                            className="w-full px-4 py-2.5 rounded-xl input-stylish text-sm"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                        />
                    </div>
                    <button 
                        type="submit" 
                        disabled={processing}
                        className="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium transition-all shadow-lg shadow-indigo-600/20 active:scale-[0.98] disabled:opacity-50"
                    >
                        {processing ? 'Cadastrando...' : 'Cadastrar Depto'}
                    </button>
                </form>
            </div>

            <div className="glass-panel rounded-2xl p-5 flex-1 flex flex-col">
                <h3 className="text-sm font-medium text-slate-400 mb-3 uppercase tracking-wider">Lista de Departamentos</h3>
                
                <div className="space-y-2 overflow-y-auto max-h-[400px] flex-1">
                    {departments.length === 0 ? (
                        <p className="text-slate-500 text-sm italic py-4 text-center border border-dashed border-slate-700 rounded-xl">
                            Nenhum departamento cadastrado.
                        </p>
                    ) : (
                        departments.map(d => (
                            <div 
                                key={d.id} 
                                onClick={() => onDepartmentClick && onDepartmentClick(d.id)}
                                className="flex items-center justify-between p-3 rounded-xl bg-slate-800/80 border border-slate-700/50 hover:border-indigo-500/50 cursor-pointer transition-colors"
                            >
                                <span className="text-slate-200 font-medium text-sm">{d.name}</span>
                                <span className="text-xs bg-slate-700 text-slate-300 px-2 py-1 rounded-md">ID #{d.id}</span>
                            </div>
                        ))
                    )}
                </div>
            </div>
        </section>
    );
}
