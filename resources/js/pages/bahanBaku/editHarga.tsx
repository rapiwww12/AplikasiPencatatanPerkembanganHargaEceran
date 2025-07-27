import { Button } from '@/components/ui/button';
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { zodResolver } from '@hookform/resolvers/zod';
import { Head, Link, router } from '@inertiajs/react';
import dayjs from 'dayjs';
import { useEffect } from 'react';
import { FormProvider, useForm } from 'react-hook-form';
import { toast } from 'sonner';
import * as z from 'zod';

interface Harga {
    id: number;
    harga: number;
    bahan_baku_id: number;
    pasar: string;
    created_at?: string;
}

interface Props {
    harga: Harga;
    flash: {
        success: string | null;
        error: string | null;
    };
}

export default function EditHarga({ harga, flash }: Props) {
    const formSchema = z.object({
        harga: z.coerce.number({ invalid_type_error: 'Harga harus berupa angka' }).min(1, 'Harga tidak boleh kosong'),
        pasar: z.string().min(1, 'Pasar harus dipilih'),
    });

    type FormValues = z.infer<typeof formSchema>;

    const methods = useForm<FormValues>({
        resolver: zodResolver(formSchema),
        defaultValues: {
            harga: harga.harga,
            pasar: harga.pasar,
        },
    });

    const { handleSubmit } = methods;

    const onSubmit = (data: FormValues) => {
        router.put(`/items/harga/${harga.id}/update`, {
            harga: data.harga,
            pasar: data.pasar,
        });
    };

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash]);

    return (
        <AppLayout
            breadcrumbs={[
                { title: 'Bahan Baku', href: '/items' },
                { title: `Edit Harga`, href: '#' },
            ]}
        >
            <Head title={`Edit Harga - ${harga.pasar}`} />
            <div className="m-10 flex max-w-full flex-col gap-4 rounded-xl border p-4">
                <h1 className="text-xl font-semibold">
                    Edit Harga - {harga.pasar} ({dayjs(harga.created_at).format('DD/MM/YYYY')})
                </h1>

                <FormProvider {...methods}>
                    <Form {...methods}>
                        <form onSubmit={handleSubmit(onSubmit)} className="space-y-6">
                            <FormField
                                name="harga"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Harga</FormLabel>
                                        <FormControl>
                                            <Input type="number" {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />

                            <FormField
                                name="pasar"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Pasar</FormLabel>
                                        <Select onValueChange={field.onChange} defaultValue={field.value}>
                                            <FormControl>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Pilih pasar" />
                                                </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                <SelectItem value="pasar betung">Pasar Betung</SelectItem>
                                                <SelectItem value="pasar sukomoro">Pasar Sukomoro</SelectItem>
                                                <SelectItem value="pasar sukajadi">Pasar Sukajadi</SelectItem>
                                                <SelectItem value="pasar kenten laut">Pasar Kenten Laut</SelectItem>
                                                <SelectItem value="pasar pangkalan balai">Pasar Pangkalan Balai</SelectItem>
                                            </SelectContent>
                                        </Select>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />

                            <div className="flex justify-end space-x-2">
                                <Button type="submit">Simpan</Button>
                                <Link href={`/items/${harga.bahan_baku_id}`}>
                                    <Button type="button" variant="secondary">
                                        Kembali
                                    </Button>
                                </Link>
                            </div>
                        </form>
                    </Form>
                </FormProvider>
            </div>
        </AppLayout>
    );
}
