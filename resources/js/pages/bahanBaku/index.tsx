import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTrigger } from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { can } from '@/utils/permission';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { ChartCandlestick, ChartNetwork, Edit, Trash } from 'lucide-react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bahan Baku',
        href: '/items',
    },
];

interface BahanBaku {
    id: number;
    nama: string;
    satuan: string;
    latest_harga?: {
        harga: number;
    } | null;
}

interface Props {
    bahanBakus: BahanBaku[];
    flash: {
        success: string | null;
        error: string | null;
    };
}

export default function BahanBakuIndex({ bahanBakus, flash }: Props) {
    const [open, setOpen] = useState(false);
    const [itemToDelete, setItemToDelete] = useState<number | null>(null);

    const page = usePage().props as {
        auth?: {
            permissions: string[];
            roles?: string[];
        };
    };

    const auth = page.auth ?? { permissions: [] };

    const { delete: destroy } = useForm();

    const handleDelete = (id: number) => {
        setItemToDelete(id);
        setOpen(true);
    };

    const confirmDelete = () => {
        if (itemToDelete) {
            destroy(`/items/${itemToDelete}`, {
                onSuccess: () => {
                    setOpen(false);
                },
            });
        }
    };

    useEffect(() => {
        if (flash.success) toast.success(flash.success);
        if (flash.error) toast.error(flash.error);
    }, [flash]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Bahan Baku" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Bahan Baku</h1>
                    {can('create-items', auth) && (
                        <Link href="/items/create">
                            <Button className="bg-primary">Tambah Bahan Baku</Button>
                        </Link>
                    )}
                </div>

                <Table className="mt-4">
                    <TableHeader>
                        <TableRow>
                            <TableHead>Nama</TableHead>
                            <TableHead>Satuan</TableHead>
                            <TableHead>Harga Terbaru</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {!bahanBakus || bahanBakus.length === 0 ? (
                            <TableRow>
                                <TableCell colSpan={12} className="text-center">
                                    Tidak ada data bahan baku.
                                </TableCell>
                            </TableRow>
                        ) : (
                            bahanBakus.map((item) => (
                                <TableRow key={item.id}>
                                    <TableCell>{item.nama}</TableCell>
                                    <TableCell>{item.satuan}</TableCell>
                                    <TableCell>
                                        {item.latest_harga ? (
                                            `Rp ${item.latest_harga.harga.toLocaleString('id-ID')}`
                                        ) : (
                                            <span className="text-red-500 italic">Belum ada harga</span>
                                        )}
                                    </TableCell>
                                    <TableCell className="flex space-x-2">
                                        {can('create-harga', auth) && (
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <Link href={`/items/${item.id}/harga`}>
                                                        <Button variant="outline" size="sm">
                                                            <ChartCandlestick className="h-4 w-4" />
                                                        </Button>
                                                    </Link>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Harga</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        )}
                                        {can('show-harga', auth) && (
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <Link href={`/items/${item.id}/show`}>
                                                        <Button variant="outline" size="sm">
                                                            <ChartNetwork className="h-4 w-4" />
                                                        </Button>
                                                    </Link>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Item</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        )}
                                        {can('edit-items', auth) && (
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <Link href={`/items/${item.id}/edit`}>
                                                        <Button variant="outline" size="sm">
                                                            <Edit className="h-4 w-4" />
                                                        </Button>
                                                    </Link>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Edit</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        )}

                                        {can('delete-items', auth) && (
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <Button variant="outline" size="sm" color="destructive" onClick={() => handleDelete(item.id)}>
                                                        <Trash className="h-4 w-4" />
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Delete</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        )}
                                    </TableCell>
                                </TableRow>
                            ))
                        )}
                    </TableBody>
                </Table>

                <Dialog open={open} onOpenChange={setOpen}>
                    <DialogTrigger />
                    <DialogContent>
                        <DialogHeader>
                            <h3 className="text-lg font-semibold">Hapus Bahan Baku</h3>
                        </DialogHeader>
                        <div className="mt-4">
                            <p>Apakah kamu yakin ingin menghapus data ini?</p>
                        </div>
                        <DialogFooter>
                            <Button variant="outline" onClick={() => setOpen(false)}>
                                Batal
                            </Button>
                            <Button color="destructive" onClick={confirmDelete}>
                                Hapus
                            </Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            </div>
        </AppLayout>
    );
}
