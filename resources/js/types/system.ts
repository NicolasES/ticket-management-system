export interface Department {
    id: number;
    name: string;
}

export interface User {
    id: number;
    name: string;
    email?: string;
    departmentId: number;
}

export interface Ticket {
    id: number;
    title: string;
    description: string;
    requesterId: number;
    departmentId: number;
    createdAt: string;
    creator?: User;
}
