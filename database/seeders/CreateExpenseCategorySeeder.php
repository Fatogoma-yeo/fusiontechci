<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class CreateExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
          [
            "name" => "Compte de vente",
            "operation" => "credit",
            "account" => '001',
            "author_id" => 0,
          ],
          [
            "name" => "Compte des achats",
            "operation" => "debit",
            "account" => '002',
            "author_id" => 0,
          ],
        ];

        foreach ($accounts as $account) {
          ExpenseCategory::create(["name" => $account["name"], "operation" => $account["operation"],
                                  "account" => $account["account"], "author_id" => $account["author_id"]]);
        }
    }
}
