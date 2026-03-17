import React, { useState } from 'react';
import { Department, Ticket, User } from '@/types/system';
import { TopHeader } from './components/TopHeader';
import { DepartmentColumn } from './components/DepartmentColumn';
import { UserColumn } from './components/UserColumn';
import { TicketColumn } from './components/TicketColumn';
import { Head } from '@inertiajs/react';
import './system.css';

interface MockSystemPageProps {
    // Props recebidas do backend Inertia
    // Quando você finalizar o DDD e as rotas, o backend deve enviar essas props
    serverDepartments?: Department[];
    serverUsers?: User[];
    serverTickets?: Ticket[];
}

export default function MockSystemIndex({ serverDepartments = [], serverUsers = [], serverTickets = [] }: MockSystemPageProps) {
    // Estado local para permitir a simulação de tela sem o backend pronto
    const [localDepartments, setLocalDepartments] = useState<Department[]>(serverDepartments || []);
    const [localUsers, setLocalUsers] = useState<User[]>(serverUsers || []);
    const [localTickets, setLocalTickets] = useState<Ticket[]>(serverTickets || []);
    const [activeUser, setActiveUser] = useState<User | null>(null);

    // Usa dados do servidor se existirem, caso contrário usa estado local para o "mock"
    const isUsingServerData = serverDepartments.length > 0 || serverUsers.length > 0;
    const departments = isUsingServerData ? serverDepartments : localDepartments;
    const users = isUsingServerData ? serverUsers : localUsers;
    const tickets = isUsingServerData ? serverTickets : localTickets;

    const seedData = () => {
        if (departments.length > 0) {
            alert('Já existem dados! Limpe recarregando a página (ou os dados estão vindo do DB).');
            return;
        }

        const defaultDepts: Department[] = [
            { id: 1, name: 'Suporte T.I' },
            { id: 2, name: 'Recursos Humanos' },
            { id: 3, name: 'Financeiro' },
        ];
        setLocalDepartments(defaultDepts);

        const defaultUsers: User[] = [
            { id: 1, name: 'João Vitor', department_id: 1, department: defaultDepts[0] },
            { id: 2, name: 'Maria Joaquina', department_id: 2, department: defaultDepts[1] },
            { id: 3, name: 'Carlos Alberto', department_id: 1, department: defaultDepts[0] },
        ];
        setLocalUsers(defaultUsers);
    };

    // --- Mock Handlers ---
    // Esses handlers são ativados quando os componentes filho percebem
    // que devem atualizar o mock local. Se os dados vierem do servidor,
    // os componentes executarão "post()" do Inertia em vez disso.

    const handleMockAddDepartment = (name: string) => {
        setLocalDepartments(prev => [...prev, { id: prev.length + 1, name }]);
    };

    const handleMockAddUser = (name: string, departmentId: number) => {
        const dept = localDepartments.find(d => d.id === departmentId);
        setLocalUsers(prev => [...prev, {
            id: prev.length + 1,
            name,
            department_id: departmentId,
            department: dept
        }]);
    };

    const handleMockAddTicket = (title: string, description: string, targetDeptId: number) => {
        if (!activeUser) return;
        const dept = localDepartments.find(d => d.id === targetDeptId);
        
        const newTicket: Ticket = {
            id: localTickets.length + 1,
            title,
            description,
            creator_id: activeUser.id,
            target_department_id: targetDeptId,
            created_at: new Date().toISOString(),
            creator: activeUser,
            target_department: dept
        };
        
        setLocalTickets(prev => [newTicket, ...prev]);
    };

    return (
        <div className="min-h-screen flex flex-col antialiased selection:bg-indigo-500 selection:text-white pb-10 bg-slate-900 text-slate-50 font-sans mock-system-scope">
            <Head title="Ticket System - Arquitetura Mock" />

            <TopHeader 
                activeUser={activeUser} 
                onSeedData={isUsingServerData ? undefined : seedData} 
            />

            <main className="flex-1 w-full max-w-7xl mx-auto mt-8 px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <DepartmentColumn 
                    departments={departments} 
                    onSubmitMock={!isUsingServerData ? handleMockAddDepartment : undefined} 
                />
                
                <UserColumn 
                    users={users} 
                    departments={departments} 
                    activeUser={activeUser} 
                    onUserLogin={setActiveUser}
                    onSubmitMock={!isUsingServerData ? handleMockAddUser : undefined}
                />
                
                <TicketColumn 
                    tickets={tickets} 
                    departments={departments} 
                    users={users}
                    activeUser={activeUser}
                    onSubmitMock={!isUsingServerData ? handleMockAddTicket : undefined}
                />

            </main>
        </div>
    );
}
