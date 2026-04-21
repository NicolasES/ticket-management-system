import { useQuery } from '@tanstack/react-query';
import { Department } from '@/types/system';

export function useDepartments() {
    return useQuery<Department[]>({
        queryKey: ['departments'],
        queryFn: async () => {
            const response = await fetch('/api/departments', {
                headers: {
                    'Accept': 'application/json',
                }
            });
            if (!response.ok) {
                throw new Error('Falha ao carregar departamentos');
            }
            return response.json();
        },
        staleTime: 1000 * 60 * 5, // Cache por 5 minutos
    });
}
