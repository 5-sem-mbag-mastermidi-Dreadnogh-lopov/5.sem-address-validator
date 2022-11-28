import { writable } from 'svelte/store';
import { notifications } from './notifications';

export const cache = writable([]);

export async function getCache() {
    const jwt = localStorage.getItem('jwt');
    if (!jwt) return;
    const response = await fetch('http://localhost:80/api/v1/address', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': jwt,
        }
    });
    if (response.ok) {
        const data = await response.json();
        cache.set(data.data);
    } else {
        notifications.danger('Error getting cache');
    }
    
}

export async function removeCache(address) {
    const jwt = localStorage.getItem('jwt');
    if (!jwt) return;
    const response = await fetch('http://localhost:80/api/v1/address', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': jwt,
        },
        body: JSON.stringify(address)
    });
    if (response.ok) {
        cache.update(c => c.filter(a => a.address_formatted !== address.address_formatted));   
        const data = await response.json();
        console.log('data', data);
    } else {
        notifications.danger('Error deleting address',1000);
    }
    //cache.set(data.data);
}
 
export async function updateCache(address) {
    const jwt = localStorage.getItem('jwt');
    if (!jwt) return;
    const response = await fetch('http://localhost:80/api/v1/address/', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': jwt,
        },
        body: JSON.stringify(address)
    });
    if (response.ok) {
        const data = await response.json();
        console.log('data', data);
    } else {
        notifications.danger('Error updating address',1000);
    }
    //cache.set(data.data);
}