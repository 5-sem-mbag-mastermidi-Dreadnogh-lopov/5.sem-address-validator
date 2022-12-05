import { get } from 'svelte/store';
import { notifications } from './notifications';
import { pageStore, JWT } from './page.store';
import { writable } from 'svelte/store';

export const cache = writable([]);

export async function getCache(addressString) {
    if (!get(JWT)) return;
    const response = await fetch(`${import.meta.env.VITE_API_HOST}api/v1/address?search_field=${addressString}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': get(JWT),
        }
    });
    if (response.ok) {
        const data = await response.json();
        cache.set(data);
        return true;
    } else if (response.status === 401) {
        notifications.danger('Unauthorized', 1000);
        pageStore.logout();
        return false;
    } else {
        notifications.danger('Error getting cache',1000);
        return false;
    }
    
}

export async function removeCache(address) {
    if (!get(JWT)) return;
    const response = await fetch(`${import.meta.env.VITE_API_HOST}api/v1/address/${address.id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': get(JWT),
        },
        body: JSON.stringify(address)
    });
    if (response.ok) {
        cache.update(c => c.filter(a => a.address_formatted !== address.address_formatted));   
        notifications.success('Address removed from cache', 1000);
    } else {
        notifications.danger('Error deleting address',1000);
    }
    //cache.set(data.data);
}
 
export async function updateCache(address) {
    if (!get(JWT)) return;
    const response = await fetch(`${import.meta.env.VITE_API_HOST}api/v1/address/${address.id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': get(JWT),
        },
        body: JSON.stringify(address)
    });
    if (response.ok) {
        const data = await response.json();
        console.log('data', data, response);
        notifications.success('Address updated', 1000);
    } else {
        notifications.danger('Error updating address',1000);
    }
    //cache.set(data.data);
}

export const JSONToDisplay = writable(null);
