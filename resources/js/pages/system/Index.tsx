import React, { useState } from 'react';
import { Department, Ticket, User } from '@/types/system';
import { TopHeader } from './components/TopHeader';
import { DepartmentColumn } from './components/DepartmentColumn';
import { UserColumn } from './components/UserColumn';
import { TicketColumn } from './components/TicketColumn';
import { Head } from '@inertiajs/react';
import { useEffect } from 'react';
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
    const [activeDepartment, setActiveDepartment] = useState<Department | null>(null);

    useEffect(() => {
        setActiveUser(null);
        localStorage.removeItem('token');
    }, [activeDepartment?.id]);


    const handleAddDepartment = (name: string) => {
        return fetch('/api/departments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                name,
            }),
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                alert('Erro ao adicionar departamento: ' + (data.message || 'Verifique os dados'));
                throw new Error(data.message || 'Erro de validação');
            }
            return data;
        })
        .then(data => {
            if (data) {
                setdepartments(prev => [...prev, { id: data.id, name: data.name }]);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            throw error;
        });
    };

    const handleAddUser = (name: string, email: string, password: string, departmentId: number) => {
        return fetch('/api/users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                name,
                email,
                password,
                departmentId: departmentId,
            }),
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                alert('Erro ao adicionar usuário: ' + (data.message || 'Verifique os dados'));
                throw new Error(data.message || 'Erro de validação');
            }
            return data;
        })
        .then(data => {
            if (data) {
                setusers(prev => [...prev, { id: data.id, name: data.name, email: data.email, department_id: data.department_id }]);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            throw error; // Re-lança para o componente saber que falhou
        });
    };

    const handleDepartmentClick = (departmentId: number) => {
        const dept = departments.find(d => d.id === departmentId);
        if (dept) setActiveDepartment(dept);

        fetch(`/api/departments/${departmentId}/users`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                alert('Erro ao carregar usuários: ' + (data.message || 'Erro no servidor'));
                return null;
            }
            return data;
        })
        .then(data => {
            if (data) {
                const formattedUsers = data.map((u: any) => ({
                    id: u.id,
                    name: u.name,
                    email: u.email,
                    department_id: u.department_id,
                    department: dept
                }));
                setusers(formattedUsers);
            }
        })
        .catch(error => console.error('Erro na requisição:', error));
    };

    const handleUserLogin = (user: User) => {
        fetch(`/api/login/direct/${user.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.access_token) {
                localStorage.setItem('token', data.access_token);
                setActiveUser(user);
            } else {
                alert('Erro ao logar: ' + (data.message || 'Verifique as credenciais'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Erro de requisição ao tentar fazer login direto.');
        });
    };

    const handleAddTicket = (title: string, description: string, targetDeptId: number) => {
        if (!activeUser) return Promise.reject('Nenhum usuário logado');
        const dept = departments.find(d => d.id === targetDeptId);
        
        return fetch('/api/tickets', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
            },
            body: JSON.stringify({
                title,
                description,
                departmentId: targetDeptId,
            })
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) {
                alert('Erro ao criar ticket: ' + (data.message || JSON.stringify(data)));
                throw new Error(data.message || 'Erro ao criar ticket');
            }
            return data;
        })
        .then(data => {
            if (data.id) {
                const newTicket: Ticket = {
                    id: data.id,
                    title: data.title,
                    description: data.description,
                    creator_id: activeUser.id,
                    target_department_id: targetDeptId,
                    created_at: new Date().toISOString(),
                    creator: activeUser,
                    target_department: dept
                };
                settickets(prev => [newTicket, ...prev]);
            }
        })
        .catch(err => {
            console.error(err);
            throw err;
        });
    };

    return (
        <div className="min-h-screen flex flex-col antialiased selection:bg-indigo-500 selection:text-white pb-10 bg-slate-900 text-slate-50 font-sans mock-system-scope">
            <Head title="Ticket System - Arquitetura Mock" />

            <TopHeader 
                activeUser={activeUser} 
                activeDepartment={activeDepartment}
            />

            <main className="flex-1 w-full max-w-7xl mx-auto mt-8 px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <DepartmentColumn 
                    departments={departments} 
                    activeDepartment={activeDepartment}
                    onSubmit={handleAddDepartment} 
                    onDepartmentClick={handleDepartmentClick}
                />
                
                <UserColumn 
                    users={users} 
                    activeUser={activeUser} 
                    activeDepartment={activeDepartment}
                    onUserLogin={handleUserLogin}
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
