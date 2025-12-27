<template>
    <SidebarProvider>
        <Sidebar collapsible="icon">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <SidebarMenuButton
                                    size="lg"
                                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                                >
                                    <div
                                        class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground"
                                    >
                                        <component
                                            :is="activeTeam.logo"
                                            class="size-4"
                                        />
                                    </div>
                                    <div
                                        class="grid flex-1 text-left text-sm leading-tight"
                                    >
                                        <span class="truncate font-semibold">{{
                                            activeTeam.name
                                        }}</span>
                                        <span class="truncate text-xs">{{
                                            activeTeam.plan
                                        }}</span>
                                    </div>
                                    <ChevronsUpDown class="ml-auto" />
                                </SidebarMenuButton>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent
                                class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                                align="start"
                                side="bottom"
                                :side-offset="4"
                            >
                                <DropdownMenuLabel
                                    class="text-xs text-muted-foreground"
                                >
                                    Teams
                                </DropdownMenuLabel>
                                <DropdownMenuItem
                                    v-for="(team, index) in data.teams"
                                    :key="team.name"
                                    class="gap-2 p-2"
                                    @click="setActiveTeam(team)"
                                >
                                    <div
                                        class="flex size-6 items-center justify-center rounded-sm border"
                                    >
                                        <component
                                            :is="team.logo"
                                            class="size-4 shrink-0"
                                        />
                                    </div>
                                    {{ team.name }}
                                    <DropdownMenuShortcut
                                        >⌘{{ index + 1 }}</DropdownMenuShortcut
                                    >
                                </DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem class="gap-2 p-2">
                                    <div
                                        class="flex size-6 items-center justify-center rounded-md border bg-background"
                                    >
                                        <Plus class="size-4" />
                                    </div>
                                    <div
                                        class="font-medium text-muted-foreground"
                                    >
                                        Add team
                                    </div>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>
            <SidebarContent>
                <SidebarGroup
                    v-for="sidebar_group in sidebar"
                    :key="sidebar_group.label"
                >
                    <SidebarGroupLabel>{{ sidebar_group.label}}</SidebarGroupLabel>
                    <SidebarMenu>
                        <template v-for="item in sidebar_group?.items">
                            <Collapsible
                                v-if="item?.items?.length"
                                as-child
                                class="group/collapsible"
                            >
                                <SidebarMenuItem>
                                    <CollapsibleTrigger
                                        as-child
                                        :class="{
                                            'cursor-pointer':
                                                !item?.items?.length,
                                        }"
                                    >
                                        <SidebarMenuButton
                                            :tooltip="item.label"
                                        >
                                            <Icon
                                                v-if="item?.icon"
                                                :name="item.icon"
                                            />
                                            <span>{{ item.label }}</span>

                                            <Badge
                                                v-if="item?.badge"
                                                class="ml-auto"
                                            >
                                                {{ item?.badge }}
                                            </Badge>

                                            <ChevronRight
                                                v-if="item?.items?.length"
                                                class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                                            />
                                        </SidebarMenuButton>
                                    </CollapsibleTrigger>

                                    <CollapsibleContent v-if="item?.items">
                                        <SidebarMenuSub>
                                            <SidebarMenuSubItem
                                                v-for="subItem in item.items"
                                                :key="subItem.label"
                                            >
                                                <SidebarMenuSubButton
                                                    as-child
                                                >
                                                    <NavLink
                                                        :href="subItem.url"
                                                    >
                                                        <span>{{
                                                            subItem.label
                                                        }}</span>
                                                    </NavLink>
                                                </SidebarMenuSubButton>
                                            </SidebarMenuSubItem>
                                        </SidebarMenuSub>
                                    </CollapsibleContent>
                                </SidebarMenuItem>
                            </Collapsible>
                            <SidebarMenuItem v-else>
                                <SidebarMenuButton
                                    :tooltip="item.label"
                                    @click="router.visit(item.url)"
                                >
                                    <Icon v-if="item?.icon" :name="item.icon" />
                                    <span>{{ item.label }}</span>

                                    <Badge
                                        v-if="item?.badge"
                                        class="ml-auto"
                                    >
                                        {{ item?.badge }}
                                    </Badge>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </template>
                    </SidebarMenu>
                </SidebarGroup>
            </SidebarContent>

            <SidebarFooter>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <SidebarMenuButton
                                    size="lg"
                                    class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                                >
                                    <Avatar class="h-8 w-8 rounded-lg">
                                        <AvatarImage
                                            :src="current_user.avatar"
                                            :alt="current_user.name"
                                        />
                                        <AvatarFallback class="rounded-lg">
                                            CN
                                        </AvatarFallback>
                                    </Avatar>
                                    <div
                                        class="grid flex-1 text-left text-sm leading-tight"
                                    >
                                        <span class="truncate font-semibold">{{
                                            current_user.name
                                        }}</span>
                                        <span class="truncate text-xs">{{
                                            current_user.email
                                        }}</span>
                                    </div>
                                    <ChevronsUpDown class="ml-auto size-4" />
                                </SidebarMenuButton>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent
                                class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                                side="bottom"
                                align="end"
                                :side-offset="4"
                            >
                                <DropdownMenuLabel class="p-0 font-normal">
                                    <div
                                        class="flex items-center gap-2 px-1 py-1.5 text-left text-sm"
                                    >
                                        <Avatar class="h-8 w-8 rounded-lg">
                                            <AvatarImage
                                                :src="current_user.avatar"
                                                :alt="current_user.name"
                                            />
                                            <AvatarFallback class="rounded-lg">
                                                CN
                                            </AvatarFallback>
                                        </Avatar>
                                        <div
                                            class="grid flex-1 text-left text-sm leading-tight"
                                        >
                                            <span
                                                class="truncate font-semibold"
                                                >{{ current_user.name }}</span
                                            >
                                            <span class="truncate text-xs">{{
                                                current_user.email
                                            }}</span>
                                        </div>
                                    </div>
                                </DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuGroup>
                                    <DropdownMenuItem>
                                        <Sparkles />
                                        Upgrade to Pro
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                                <DropdownMenuSeparator />
                                <DropdownMenuGroup>
                                    <DropdownMenuItem>
                                        <BadgeCheck />
                                        Account
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>
                                        <CreditCard />
                                        Billing
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>
                                        <Bell />
                                        Notifications
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem
                                    @click="() => router.visit(logout())"
                                >
                                    <LogOut />
                                    Log out
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarFooter>
            <SidebarRail />
        </Sidebar>
        <SidebarInset
            class="transition-[margin-left] ease-linear md:peer-data-[state=expanded]:ml-[var(--sidebar-width)] md:peer-data-[state=collapsed]:ml-[var(--sidebar-width-icon)]"
        >
            <header
                class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12"
            >
                <div class="flex items-center gap-2 px-4">
                    <SidebarTrigger class="-ml-1" />
                    <Separator orientation="vertical" class="mr-2 h-4" />

                    <!----------------------------------------------->
                    <!-- Breadcrumb -->
                    <!----------------------------------------------->
                    <Breadcrumb>
                        <BreadcrumbList>
                            <template
                                v-for="(breadcrumb, index) in breadcrumbs"
                            >
                                <BreadcrumbItem class="hidden md:flex md:gap-1">
                                    <Icon
                                        v-if="breadcrumb?.icon"
                                        class="h-4 w-4 rounded-lg"
                                        :name="breadcrumb?.icon"
                                    ></Icon>
                                    <NavLink :href="breadcrumb.url">
                                        {{ breadcrumb.label }}
                                    </NavLink>
                                </BreadcrumbItem>

                                <BreadcrumbSeparator
                                    v-if="index !== breadcrumbs?.length - 1"
                                    class="hidden md:block"
                                />
                            </template>
                        </BreadcrumbList>
                    </Breadcrumb>
                </div>
            </header>

            <!----------------------------------------------->
            <!-- Title Page -->
            <!----------------------------------------------->
            <div
                :class="[
                    'mt-2 px-3',
                    { 'mb-10': !quick_menu?.length },
                    { 'mb-3': quick_menu?.length },
                ]"
            >
                <span class="text-2xl font-semibold" v-html="titre_page" />
            </div>

            <!----------------------------------------------->
            <!-- Quick Menu -->
            <!----------------------------------------------->
            <div v-if="quick_menu?.length" class="mt-2 mb-10 w-full px-3">
                <Tabs :default-value="current_route" class="w-full">
                    <TabsList class="inline-flex flex-wrap justify-start gap-1">
                        <TabsTrigger
                            v-for="item in quick_menu"
                            :value="item.url"
                            @click="() => router.get(item.url)"
                        >
                            <div
                                class="flex flex-row items-center justify-center gap-1"
                            >
                                <Icon
                                    v-if="item?.icon"
                                    :name="item?.icon"
                                    class="h-4 w-4"
                                ></Icon>
                                <span class="font-normal">{{
                                    item.label
                                }}</span>
                            </div>
                        </TabsTrigger>
                    </TabsList>
                </Tabs>
            </div>

            <!----------------------------------------------->
            <!-- Content -->
            <!----------------------------------------------->
            <div
                class="mlk^poiuh,;:=ùmù`$-)eml-20 flex flex-1 flex-col gap-4 p-4 pt-0"
            >
                <slot></slot>

                <!--                <div class="grid auto-rows-min gap-4 md:grid-cols-3">-->
                <!--                    <div class="aspect-video rounded-xl bg-muted/50"/>-->
                <!--                    <div class="aspect-video rounded-xl bg-muted/50"/>-->
                <!--                    <div class="aspect-video rounded-xl bg-muted/50"/>-->
                <!--                </div>-->
                <!--                <div class="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min"/>-->
            </div>
        </SidebarInset>
    </SidebarProvider>

    <Notifications />
</template>

<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';

import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbList,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';

import { Badge } from '@/components/ui/badge';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Separator } from '@/components/ui/separator';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarInset,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
    SidebarProvider,
    SidebarRail,
    SidebarTrigger,
} from '@/components/ui/sidebar';
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';
import Icon from '@/custom-components/icon.vue';
import NavLink from '@/custom-components/nav-link.vue';
import Notifications from '@/custom-components/notifications/notifications.vue';
import { logout } from '@/routes';
import { router, usePage } from '@inertiajs/vue3';
import {
    AudioWaveform,
    BadgeCheck,
    Bell,
    BookOpen,
    Bot,
    ChevronRight,
    ChevronsUpDown,
    Command,
    CreditCard,
    Frame,
    GalleryVerticalEnd,
    LogOut,
    Map,
    PieChart,
    Plus,
    Settings2,
    Sparkles,
    SquareTerminal,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { route } from 'ziggy-js';

const sidebar = computed(() => usePage().props?.sidebar_content);
const current_user = computed<{
    name: string;
    email: string;
    avatar: string;
}>(() => usePage().props?.current_user);

// This is sample data.
const data = {
    teams: [
        {
            name: 'Acme Inc',
            logo: GalleryVerticalEnd,
            plan: 'Enterprise',
        },
        {
            name: 'Acme Corp.',
            logo: AudioWaveform,
            plan: 'Startup',
        },
        {
            name: 'Evil Corp.',
            logo: Command,
            plan: 'Free',
        },
    ],
    navMain: [
        {
            title: 'Playground',
            url: '#',
            icon: SquareTerminal,
            isActive: true,
            items: [
                {
                    title: 'History',
                    url: '#',
                },
                {
                    title: 'Starred',
                    url: '#',
                },
                {
                    title: 'Settings',
                    url: '#',
                },
            ],
        },
        {
            title: 'Models',
            url: '#',
            icon: Bot,
            items: [
                {
                    title: 'Genesis',
                    url: '#',
                },
                {
                    title: 'Explorer',
                    url: '#',
                },
                {
                    title: 'Quantum',
                    url: '#',
                },
            ],
        },
        {
            title: 'Documentation',
            url: '#',
            icon: BookOpen,
            items: [
                {
                    title: 'Introduction',
                    url: '#',
                },
                {
                    title: 'Get Started',
                    url: '#',
                },
                {
                    title: 'Tutorials',
                    url: '#',
                },
                {
                    title: 'Changelog',
                    url: '#',
                },
            ],
        },
        {
            title: 'Settings',
            url: '#',
            icon: Settings2,
            items: [
                {
                    title: 'General',
                    url: '#',
                },
                {
                    title: 'Team',
                    url: '#',
                },
                {
                    title: 'Billing',
                    url: '#',
                },
                {
                    title: 'Limits',
                    url: '#',
                },
            ],
        },
    ],
    projects: [
        {
            name: 'Design Engineering',
            url: '#',
            icon: Frame,
        },
        {
            name: 'Sales & Marketing',
            url: '#',
            icon: PieChart,
        },
        {
            name: 'Travel',
            url: '#',
            icon: Map,
        },
    ],
};

const activeTeam = ref(data.teams[0]);
const breadcrumbs = computed(() => usePage().props.breadcrumbs);
const quick_menu = computed(() => usePage().props.quick_menu);
const titre_page = computed(() => usePage().props.title_page);
const current_route = computed(
    () => route(route().current(), route().params)?.toString()?.split('?')[0],
);

function setActiveTeam(team: (typeof data.teams)[number]) {
    activeTeam.value = team;
}
</script>
