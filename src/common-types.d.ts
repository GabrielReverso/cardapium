interface FoodItem {
    id: string,
    categoria: string,
    nome: string,
    descricao: string,
    foto?: string,
    preco: string
}

interface FoodItems {
    [key: string]: FoodItem[]
}
