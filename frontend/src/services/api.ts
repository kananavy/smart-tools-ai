import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    withCredentials: true,
    withXSRFToken: true,
});

api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});


export interface Tool {
    id: number;
    name: string;
    slug: string;
    type: string;
    description: string;
}

export const getTools = async () => {
    const response = await api.get<Tool[]>('/tools');
    return response.data;
};

export interface GenerateOptions {
    prompt: string;
    tone?: string;
    length?: string;
    image?: string;
}

export interface GenerateResponse {
    result: string;
    remaining: number;
}

export const generateContent = async (slug: string, data: GenerateOptions) => {
    const response = await api.post<GenerateResponse>(`/tools/${slug}/generate`, data);
    return response.data;
};

export default api;
