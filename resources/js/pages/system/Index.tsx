import React, { useState } from 'react';
import { Department, Ticket, User } from '@/types/system';
import { TopHeader } from './components/TopHeader';
import { DepartmentColumn } from './components/DepartmentColumn';
import { UserColumn } from './components/UserColumn';
import { TicketColumn } from './components/TicketColumn';
import { Head } from '@inertiajs/react';
import './system.css';

interface SystemPageProps {
    serverDepartments?: Department[];
    serverUsers?: User[];
    serverTickets?: Ticket[];
}

export default function SystemIndex({ serverDepartments = [], serverUsers = [], serverTickets = [] }: SystemPageProps) {
    // Estado local para permitir a simulação de tela sem o backend pronto
    const [departments, setdepartments] = useState<Department[]>(serverDepartments || []);
    const [users, setusers] = useState<User[]>(serverUsers || []);
    const [tickets, settickets] = useState<Ticket[]>(serverTickets || []);
    const [activeUser, setActiveUser] = useState<User | null>(null);

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
        setdepartments(defaultDepts);

        const defaultUsers: User[] = [
            { id: 1, name: 'João Vitor', department_id: 1, department: defaultDepts[0] },
            { id: 2, name: 'Maria Joaquina', department_id: 2, department: defaultDepts[1] },
            { id: 3, name: 'Carlos Alberto', department_id: 1, department: defaultDepts[0] },
        ];
        setusers(defaultUsers);
    };

    const handleAddDepartment = (name: string) => {
        fetch('/api/departments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // 'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
            body: JSON.stringify({
                name,
            }),
        })
        .then(response => response.json())
        .then(data => {
            setdepartments(prev => [...prev, { id: data.id, name: data.name }]);
        })
        .catch(error => console.log(error));
    };

    const handleAddUser = (name: string, departmentId: number) => {
        const dept = departments.find(d => d.id === departmentId);
        setusers(prev => [...prev, {
            id: prev.length + 1,
            name,
            department_id: departmentId,
            department: dept
        }]);
    };

    const handleAddTicket = (title: string, description: string, targetDeptId: number) => {
        if (!activeUser) return;
        const dept = departments.find(d => d.id === targetDeptId);
        
        const newTicket: Ticket = {
            id: tickets.length + 1,
            title,
            description,
            creator_id: activeUser.id,
            target_department_id: targetDeptId,
            created_at: new Date().toISOString(),
            creator: activeUser,
            target_department: dept
        };
        
        settickets(prev => [newTicket, ...prev]);
    };

    return (
        <div className="min-h-screen flex flex-col antialiased selection:bg-indigo-500 selection:text-white pb-10 bg-slate-900 text-slate-50 font-sans mock-system-scope">
            <Head title="Ticket System - Arquitetura Mock" />

            <TopHeader 
                activeUser={activeUser} 
                onSeedData={seedData} 
            />

            <main className="flex-1 w-full max-w-7xl mx-auto mt-8 px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <DepartmentColumn 
                    departments={departments} 
                    onSubmit={handleAddDepartment} 
                />
                
                <UserColumn 
                    users={users} 
                    departments={departments} 
                    activeUser={activeUser} 
                    onUserLogin={setActiveUser}
                    onSubmit={handleAddUser}
                />
                
                <TicketColumn 
                    tickets={tickets} 
                    departments={departments} 
                    users={users}
                    activeUser={activeUser}
                    onSubmit={handleAddTicket}
                />

            </main>
        </div>
    );
}
