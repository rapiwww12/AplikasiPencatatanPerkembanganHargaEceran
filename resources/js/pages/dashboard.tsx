'use client';

import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { ChartConfig, ChartContainer, ChartTooltip, ChartTooltipContent } from '@/components/ui/chart';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { TrendingUp } from 'lucide-react';
import { useState } from 'react';
import { CartesianGrid, Line, LineChart, XAxis } from 'recharts';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface HargaEntry {
    label: string;
    harga: number;
}

interface HargaData {
    mingguan: HargaEntry[];
    bulanan: HargaEntry[];
}

type DashboardData = Record<string, HargaData>;

const chartConfig = {
    desktop: {
        label: 'Desktop',
        color: 'hsl(var(--chart-1))',
    },
} satisfies ChartConfig;

export default function Dashboard() {
    const { data } = usePage<{ data: DashboardData }>().props;

    const bahanKeys = Object.keys(data) as (keyof typeof data)[];
    const [selectedBahan, setSelectedBahan] = useState<keyof typeof data>(bahanKeys[0]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex flex-col items-start gap-2 md:flex-row md:items-center">
                    <Label className="text-lg font-semibold">Pilih Bahan Baku:</Label>
                    <Select value={selectedBahan} onValueChange={(value) => setSelectedBahan(value as keyof typeof data)}>
                        <SelectTrigger className="w-[200px]">
                            <SelectValue placeholder="Pilih bahan" />
                        </SelectTrigger>
                        <SelectContent>
                            {bahanKeys.map((bahan) => (
                                <SelectItem key={bahan} value={bahan}>
                                    {bahan}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>

                <div className="grid gap-4 md:grid-cols-2">
                    <Card>
                        <CardHeader>
                            <CardTitle>Chart Mingguan</CardTitle>
                            <CardDescription>Mingguan Data Harga Bahan Baku</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <ChartContainer config={chartConfig}>
                                <LineChart data={data[selectedBahan].mingguan} margin={{ top: 100, left: 12, right: 12 }}>
                                    <CartesianGrid vertical={false} />
                                    <XAxis dataKey="label" tickLine={false} axisLine={false} tickMargin={8} />
                                    <ChartTooltip cursor={false} content={<ChartTooltipContent hideLabel />} />
                                    <Line dataKey="harga" type="linear" stroke="#3A59D1" strokeWidth={2} dot={false} />
                                </LineChart>
                            </ChartContainer>
                        </CardContent>
                        <CardFooter className="flex-col items-start gap-2 text-sm">
                            <div className="flex gap-2 leading-none font-medium">
                                Trending up <TrendingUp className="h-4 w-4" />
                            </div>
                            <div className="text-muted-foreground leading-none">Harga bahan baku mingguan</div>
                        </CardFooter>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Chart Bulanan</CardTitle>
                            <CardDescription>Bulanan Data Harga Bahan Baku</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <ChartContainer config={chartConfig}>
                                <LineChart data={data[selectedBahan].bulanan} margin={{ top: 100, left: 12, right: 12 }}>
                                    <CartesianGrid vertical={false} />
                                    <XAxis dataKey="label" tickLine={false} axisLine={false} tickMargin={8} />
                                    <ChartTooltip cursor={false} content={<ChartTooltipContent hideLabel />} />
                                    <Line dataKey="harga" type="linear" stroke="#3A59D1" strokeWidth={2} dot={false} />
                                </LineChart>
                            </ChartContainer>
                        </CardContent>
                        <CardFooter className="flex-col items-start gap-2 text-sm">
                            <div className="flex gap-2 leading-none font-medium">
                                Trending up <TrendingUp className="h-4 w-4" />
                            </div>
                            <div className="text-muted-foreground leading-none">Harga bahan baku bulanan</div>
                        </CardFooter>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
