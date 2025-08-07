<?php

namespace App\Services;

use App\Models\User;

class ServiceUserService
{
    /**
     * Récupérer les utilisateurs filtrés avec pagination
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUsers(array $filters = [], int $perPage = 40)
    {
        $query = User::with('specialite')
            ->whereIn('role', ['formateur', 'repetiteur', 'encadreur'])
            ->where('statusCompte', true);

        if (!empty($filters['specialite_id'])) {
            $query->where('specialite_id', $filters['specialite_id']);
        }

        if (!empty($filters['ville_id'])) {
            $query->where('ville_id', $filters['ville_id']);
        }

        if (!empty($filters['commune_id'])) {
            $query->where('commune_id', $filters['commune_id']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Récupérer un utilisateur par ID avec sa spécialité
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return User::with('specialite')->find($id);
    }
}
