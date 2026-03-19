export interface Department {
    id: number;
    name: string;
}

export interface User {
    id: number;
    name: string;
    department_id: number;
}

export interface Ticket {
    id: number;
    title: string;
    description: string;
    creator_id: number;
    target_department_id: number;
    created_at: string;
    creator?: User;
    target_department?: Department;
}
