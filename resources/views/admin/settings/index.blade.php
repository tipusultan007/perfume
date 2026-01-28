@extends('admin.layouts.app')

@section('title', 'Global Settings')
@section('page_title', 'Configuration')

@section('content')
<div class="flex flex-col lg:flex-row gap-10 items-start" x-data="{ tab: 'general' }">
    <!-- Sidebar Tabs Nav -->
    <div class="w-full lg:w-72 flex-shrink-0 flex flex-col gap-2 bg-white p-6 border border-slate-200 rounded-2xl shadow-sm sticky top-24">
        <button @click="tab = 'general'" 
            :class="tab === 'general' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-settings-4-line text-lg"></i> General
        </button>
        <button @click="tab = 'contact'" 
            :class="tab === 'contact' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-mail-line text-lg"></i> Contact
        </button>
        <button @click="tab = 'social'" 
            :class="tab === 'social' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-links-line text-lg"></i> Social
        </button>
        <button @click="tab = 'navigation'" 
            :class="tab === 'navigation' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-menu-line text-lg"></i> Navigation
        </button>
        <button @click="tab = 'footer'" 
            :class="tab === 'footer' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-layout-bottom-line text-lg"></i> Footer
        </button>
        <button @click="tab = 'tax'" 
            :class="tab === 'tax' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-percent-line text-lg"></i> Tax
        </button>
        <button @click="tab = 'announcement'" 
            :class="tab === 'announcement' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-notification-badge-line text-lg"></i> Announcement
        </button>
        <button @click="tab = 'integrations'" 
            :class="tab === 'integrations' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-puzzle-line text-lg"></i> Integrations
        </button>
        <button @click="tab = 'status'" 
            :class="tab === 'status' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-shield-flash-line text-lg"></i> Site Status
        </button>
        <button @click="tab = 'mail'" 
            :class="tab === 'mail' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-mail-send-line text-lg"></i> Email Settings
        </button>
        <button @click="tab = 'tools'" 
            :class="tab === 'tools' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20 active-tab' : 'bg-white text-slate-500 hover:bg-slate-50 border-transparent hover:border-slate-200'" 
            class="w-full px-6 py-4 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-3">
            <i class="ri-tools-line text-lg"></i> System Tools
        </button>
    </div>

    <!-- Tab Content -->
    <div class="flex-1 w-full space-y-8">
        @if(session('success'))
        <div class="p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-widest flex items-center rounded-xl shadow-sm">
            <i class="ri-checkbox-circle-line mr-3 text-xl"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="p-5 bg-rose-50 border border-rose-100 text-rose-700 text-xs font-bold uppercase tracking-widest flex items-center rounded-xl shadow-sm">
            <i class="ri-error-warning-line mr-3 text-xl"></i> {{ session('error') }}
        </div>
        @endif

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-8 md:p-12">

        <!-- General Tab -->
        <div x-show="tab === 'general'" x-cloak class="space-y-8 animate-in fade-in duration-500">
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">General Configuration</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Standard Branding & Identity</p>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="update_general" value="1">
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'L\'ESSENCE' }}" 
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Site Description</label>
                    <textarea name="site_description" rows="4" 
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">{{ $settings['site_description'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Site Logo</label>
                    @if(isset($settings['site_logo']))
                        <div class="mb-4 p-4 bg-slate-50 border border-slate-200 rounded-xl w-fit">
                            <img src="{{ asset($settings['site_logo']) }}" alt="Current Logo" class="h-12 object-contain">
                        </div>
                    @endif
                    <input type="file" name="site_logo" accept="image/*"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    <p class="text-[10px] text-slate-400 mt-2 font-medium">Recommended height: 40-60px. Format: PNG, JPG, SVG.</p>
                </div>
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save General Changes
                </button>
            </form>
        </div>

        <!-- Contact Tab -->
        <div x-show="tab === 'contact'" x-cloak class="space-y-8 animate-in fade-in duration-500">
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Contact Information</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">How customers can reach you</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="update_contact" value="1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Email Address</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Phone Number</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Office Address</label>
                    <textarea name="contact_address" rows="3" 
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">{{ $settings['contact_address'] ?? '' }}</textarea>
                </div>
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save Contact Info
                </button>
            </form>
        </div>

        <!-- Social Tab -->
        <div x-show="tab === 'social'" x-cloak class="space-y-8 animate-in fade-in duration-500">
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Social Media Links</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Connect your platform profiles</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="update_social" value="1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Facebook URL</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Instagram URL</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Twitter / X URL</label>
                        <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Pinterest URL</label>
                        <input type="url" name="social_pinterest" value="{{ $settings['social_pinterest'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                </div>
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save Social Links
                </button>
            </form>
        </div>

        <!-- Navigation Tab -->
        <div x-show="tab === 'navigation'" x-cloak x-data="{
            menuItems: {{ $settings['nav_menu_json'] ?? '[]' }},
            addParent() {
                this.menuItems.push({ label: '', url: '', children: [] });
            },
            addChild(parentIndex) {
                 if (!this.menuItems[parentIndex]) return;
                if (!this.menuItems[parentIndex].children) {
                    this.menuItems[parentIndex].children = [];
                }
                this.menuItems[parentIndex].children.push({ label: '', url: '' });
            },
            removeParent(index) {
                this.menuItems.splice(index, 1);
            },
            removeChild(parentIndex, childIndex) {
                this.menuItems[parentIndex].children.splice(childIndex, 1);
            },
            moveUp(index) {
                if(index > 0) {
                    const item = this.menuItems[index];
                    this.menuItems.splice(index, 1);
                    this.menuItems.splice(index - 1, 0, item);
                }
            },
            moveDown(index) {
                if(index < this.menuItems.length - 1) {
                    const item = this.menuItems[index];
                    this.menuItems.splice(index, 1);
                    this.menuItems.splice(index + 1, 0, item);
                }
            }
        }" class="space-y-8 animate-in fade-in duration-500">
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Custom Navigation Links</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Manage your website's header menu</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="update_nav" value="1">
                <input type="hidden" name="nav_menu_json" :value="JSON.stringify(menuItems)">
                
                <div class="space-y-6">
                    <template x-for="(item, index) in menuItems" :key="index">
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 md:p-8 animate-in fade-in slide-in-from-left-4 duration-300">
                            <!-- Parent Row -->
                            <div class="flex flex-wrap md:flex-nowrap gap-6 items-center">
                                <div class="flex flex-col gap-2">
                                    <button type="button" @click="moveUp(index)" class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-slate-900 hover:border-slate-900 rounded-lg transition-all shadow-sm">
                                        <i class="ri-arrow-up-s-line"></i>
                                    </button>
                                    <button type="button" @click="moveDown(index)" class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-slate-900 hover:border-slate-900 rounded-lg transition-all shadow-sm">
                                        <i class="ri-arrow-down-s-line"></i>
                                    </button>
                                </div>
                                <div class="flex-1 space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <input type="text" x-model="item.label" placeholder="Menu Label" 
                                            class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-bold">
                                        <input type="text" x-model="item.url" placeholder="URL (e.g. /shop)" 
                                            class="w-full px-5 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-mono">
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                     <button type="button" @click="addChild(index)" 
                                        class="px-5 py-3 bg-white border border-slate-200 text-[10px] font-bold uppercase tracking-widest text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 rounded-xl transition-all shadow-sm flex items-center gap-2">
                                        <i class="ri-add-line"></i> Sub Item
                                    </button>
                                    <button type="button" @click="removeParent(index)" 
                                        class="w-11 h-11 flex items-center justify-center bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white rounded-xl transition-all shadow-sm">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Children -->
                            <div class="mt-8 space-y-4 md:ml-20 pl-6 border-l-2 border-slate-200" x-show="item.children && item.children.length > 0">
                                <template x-for="(child, cIndex) in item.children" :key="cIndex">
                                    <div class="flex gap-4 items-center animate-in fade-in slide-in-from-top-2">
                                        <div class="flex-shrink-0 text-slate-300">
                                            <i class="ri-corner-down-right-line text-xl"></i>
                                        </div>
                                        <input type="text" x-model="child.label" placeholder="Sub Item Label" 
                                            class="flex-1 px-4 py-2.5 bg-white border border-slate-100 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                                        <input type="text" x-model="child.url" placeholder="Sub Item URL" 
                                            class="flex-1 px-4 py-2.5 bg-white border border-slate-100 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-mono">
                                        <button type="button" @click="removeChild(index, cIndex)" class="text-slate-300 hover:text-rose-500 transition-colors p-2">
                                            <i class="ri-close-circle-line text-lg"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="pt-4">
                     <button type="button" @click="addParent()" 
                        class="group py-6 px-10 border-2 border-dashed border-slate-200 rounded-2xl text-[11px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-900 hover:border-slate-900 hover:bg-slate-50 w-full transition-all flex items-center justify-center gap-4">
                        <i class="ri-add-circle-line text-2xl"></i> Add Main Menu Link
                    </button>
                </div>

                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save Navigation Architecture
                </button>
            </form>
        </div>

        <!-- Footer Tab -->
        <div x-show="tab === 'footer'" x-cloak class="space-y-8 animate-in fade-in duration-500">
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Footer Configuration</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Website legal & copyright info</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="update_footer" value="1">
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Copyright Text</label>
                    <input type="text" name="footer_copyright" value="{{ $settings['footer_copyright'] ?? '© 2026 L\'ESSENCE NYC. All rights reserved.' }}" 
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                </div>
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save Footer Changes
                </button>
            </form>
        </div>

        <!-- Tax Tab -->
        <div x-show="tab === 'tax'" x-cloak class="space-y-8 animate-in fade-in duration-500">
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Tax System Switch</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Global toggle for tax calculations</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-10">
                @csrf
                <input type="hidden" name="update_tax_settings" value="1">
                @php $taxEnabled = \App\Models\Setting::get('tax_enabled', false); @endphp
                
                <div class="flex items-center justify-between p-8 bg-slate-50 border border-slate-200 rounded-2xl">
                    <div class="max-w-md">
                        <h4 class="text-base font-bold text-slate-900 mb-2">Enable Tax Calculation</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">When active, the system will apply defined tax rates during checkout based on the customer's shipping address. If disabled, all products are treated as tax-free.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="tax_enabled" value="1" class="sr-only peer" {{ $taxEnabled ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                    </label>
                </div>
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save Tax Settings
                </button>
            </form>
        </div>

        <!-- Announcement Tab -->
        <div x-show="tab === 'announcement'" x-cloak class="space-y-8 animate-in fade-in duration-500">
             <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Announcement Bar</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Top-level promotion controls</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-10">
                @csrf
                <input type="hidden" name="update_announcement_bar" value="1">
                
                <div class="flex items-center justify-between p-8 bg-slate-50 border border-slate-200 rounded-2xl">
                    <div class="max-w-md">
                        <h4 class="text-base font-bold text-slate-900 mb-2">Show Global Announcement Bar</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Toggle the visibility of the sticky promotion bar at the very top of your website pages.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="topbar_visible" value="1" class="sr-only peer" {{ \App\Models\Setting::get('topbar_visible', false) ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-4">Background Accent Color</label>
                        <div class="flex items-center gap-5 bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <input type="color" name="topbar_bg" value="{{ $settings['topbar_bg'] ?? '#0F172A' }}" 
                                class="w-16 h-16 border-4 border-white bg-transparent cursor-pointer rounded-lg shadow-sm">
                            <div class="flex-1">
                                <input type="text" value="{{ $settings['topbar_bg'] ?? '#0F172A' }}" 
                                    class="w-full bg-transparent border-none focus:ring-0 text-sm font-bold font-mono text-slate-900 uppercase" readonly>
                                <p class="text-[9px] text-slate-400 uppercase tracking-widest font-bold mt-1">HEX Code</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-4">Typography Color</label>
                        <div class="flex items-center gap-5 bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <input type="color" name="topbar_text_color" value="{{ $settings['topbar_text_color'] ?? '#FFFFFF' }}" 
                                class="w-16 h-16 border-4 border-white bg-transparent cursor-pointer rounded-lg shadow-sm">
                            <div class="flex-1">
                                <input type="text" value="{{ $settings['topbar_text_color'] ?? '#FFFFFF' }}" 
                                    class="w-full bg-transparent border-none focus:ring-0 text-sm font-bold font-mono text-slate-900 uppercase" readonly>
                                <p class="text-[9px] text-slate-400 uppercase tracking-widest font-bold mt-1">HEX Code</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-between items-center">
                     <a href="{{ route('admin.announcements.index') }}" 
                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-900 flex items-center gap-2 transition-colors">
                        <i class="ri-edit-circle-line text-lg"></i> Manage Announcement Content
                     </a>
                     <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                        Update Announcement Styling
                    </button>
                </div>
            </form>
        </div>

        <!-- Integrations Tab -->
        <div x-show="tab === 'integrations'" x-cloak class="space-y-8 animate-in fade-in duration-500">
             <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Third-Party Integrations</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Connect External Services</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-10">
                @csrf
                <input type="hidden" name="update_integrations" value="1">
                
                <!-- Google Analytics -->
                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl space-y-4">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="ri-google-fill text-2xl text-slate-700"></i>
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest">Google Analytics 4</h4>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Measurement ID (G-XXXXXXXXXX)</label>
                        <input type="text" name="google_analytics_id" value="{{ \App\Models\Setting::get('google_analytics_id') ?? '' }}" placeholder="G-XXXXXXXXXX"
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-mono">
                    </div>
                </div>

                <!-- Google reCAPTCHA -->
                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl space-y-6">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="ri-shield-check-fill text-2xl text-slate-700"></i>
                         <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest">Google reCAPTCHA v2</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Site Key</label>
                            <input type="text" name="recaptcha_site_key" value="{{ \App\Models\Setting::get('recaptcha_site_key') ?? '' }}" 
                                class="w-full px-5 py-4 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-mono">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Secret Key</label>
                            <input type="password" name="recaptcha_secret_key" value="{{ \App\Models\Setting::get('recaptcha_secret_key') ?? '' }}" 
                                class="w-full px-5 py-4 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-mono">
                        </div>
                    </div>
                </div>

                <!-- Google Ads -->
                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl space-y-4">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="ri-advertisement-fill text-2xl text-slate-700"></i>
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest">Google Ads Conversion Tracking</h4>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Conversion ID (AW-XXXXXXXXX)</label>
                        <input type="text" name="google_ads_id" value="{{ \App\Models\Setting::get('google_ads_id') ?? '' }}" placeholder="AW-XXXXXXXXX"
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-mono">
                        
                        <div class="mt-3 bg-white p-4 rounded-xl border border-dashed border-slate-200">
                            <h5 class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-600 mb-1">
                                <i class="ri-information-line"></i> How to find your ID:
                            </h5>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Go to <strong>Google Ads > Goals > Conversions > Summary</strong>. Select a conversion action, click <strong>Tag Setup</strong>, then choose "Install the tag yourself" or "Use Google Tag Manager". Your ID starts with <strong>AW-</strong> (e.g., AW-123456789).
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Meta Pixel -->
                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl space-y-4">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="ri-facebook-circle-fill text-2xl text-slate-700"></i>
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest">Meta (Facebook) Pixel</h4>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Pixel ID</label>
                        <input type="text" name="facebook_pixel_id" value="{{ \App\Models\Setting::get('facebook_pixel_id') ?? '' }}" placeholder="1234567890"
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-mono">
                        
                         <div class="mt-3 bg-white p-4 rounded-xl border border-dashed border-slate-200">
                            <h5 class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-600 mb-1">
                                <i class="ri-information-line"></i> How to find your ID:
                            </h5>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Go to <strong>Meta Events Manager > Data Sources</strong>. Select your Pixel from the list. Go to the <strong>Settings</strong> tab. Copy the long numeric string under <strong>Pixel ID</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save Integration Keys
                </button>
            </form>
        </div>

        <!-- Mail Tab -->
        <div x-show="tab === 'mail'" x-cloak class="space-y-8 animate-in fade-in duration-500">
             <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Mail Configuration</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">SMTP & Sending Settings</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-10">
                @csrf
                <input type="hidden" name="update_mail" value="1">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Mail Mailer</label>
                        <input type="text" name="mail_mailer" value="{{ $settings['mail_mailer'] ?? 'smtp' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Mail Host</label>
                        <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Mail Port</label>
                        <input type="text" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Mail Encryption</label>
                        <input type="text" name="mail_encryption" value="{{ $settings['mail_encryption'] ?? 'tls' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Mail Username</label>
                        <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Mail Password</label>
                        <input type="password" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Mail From Address</label>
                        <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-3">Mail From Name</label>
                        <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}" 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                </div>

                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save Mail Settings
                </button>
            </form>

            <div class="pt-10 border-t border-slate-100">
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-8">
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-4">Validate Configuration</h4>
                    <p class="text-xs text-slate-500 mb-6 font-medium">Enter an email address below to send a test message using your current SMTP settings. Make sure to save changes before testing.</p>
                    
                    <form action="{{ route('admin.settings.test-smtp') }}" method="POST" class="flex flex-wrap md:flex-nowrap gap-4">
                        @csrf
                        <input type="email" name="test_email" placeholder="recipient@example.com" required
                            class="flex-1 px-5 py-4 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                        <button type="submit" class="px-8 py-4 bg-white border-2 border-slate-900 text-slate-900 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all whitespace-nowrap">
                            Send Connection Test
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Site Status Tab -->
        <div x-show="tab === 'status'" x-cloak class="space-y-8 animate-in fade-in duration-500">
             <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">Site Visibility & Status</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Control public access to your atelier</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-10">
                @csrf
                <input type="hidden" name="update_site_status" value="1">
                
                @php $currentStatus = \App\Models\Setting::get('site_status', 'live'); @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Live Mode -->
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="site_status" value="live" class="peer sr-only" {{ $currentStatus === 'live' ? 'checked' : '' }}>
                        <div class="p-8 bg-slate-50 border-2 border-transparent rounded-2xl transition-all peer-checked:bg-emerald-50 peer-checked:border-emerald-500 flex flex-col items-center text-center">
                            <i class="ri-global-line text-4xl mb-4 text-slate-400 group-hover:scale-110 transition-transform peer-checked:text-emerald-500"></i>
                            <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-2">Live Mode</h4>
                            <p class="text-[10px] text-slate-500 leading-relaxed uppercase font-bold tracking-tight">The boutique is open for business and accessible to everyone.</p>
                        </div>
                    </label>

                    <!-- Maintenance Mode -->
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="site_status" value="maintenance" class="peer sr-only" {{ $currentStatus === 'maintenance' ? 'checked' : '' }}>
                        <div class="p-8 bg-slate-50 border-2 border-transparent rounded-2xl transition-all peer-checked:bg-amber-50 peer-checked:border-amber-500 flex flex-col items-center text-center">
                            <i class="ri-hammer-line text-4xl mb-4 text-slate-400 group-hover:scale-110 transition-transform peer-checked:text-amber-500"></i>
                            <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-2">Maintenance</h4>
                            <p class="text-[10px] text-slate-500 leading-relaxed uppercase font-bold tracking-tight">Show a "Evolving" message. Only admins can access the shop.</p>
                        </div>
                    </label>

                    <!-- Coming Soon Mode -->
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="site_status" value="coming_soon" class="peer sr-only" {{ $currentStatus === 'coming_soon' ? 'checked' : '' }}>
                        <div class="p-8 bg-slate-50 border-2 border-transparent rounded-2xl transition-all peer-checked:bg-indigo-50 peer-checked:border-indigo-500 flex flex-col items-center text-center">
                            <i class="ri-timer-flash-line text-4xl mb-4 text-slate-400 group-hover:scale-110 transition-transform peer-checked:text-indigo-500"></i>
                            <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-2">Coming Soon</h4>
                            <p class="text-[10px] text-slate-500 leading-relaxed uppercase font-bold tracking-tight">Perfect for pre-launch. Show a branded splash page to guests.</p>
                        </div>
                    </label>
                </div>

                <div class="p-8 bg-amber-50 border border-amber-100 rounded-2xl flex items-start gap-4">
                    <i class="ri-information-fill text-2xl text-amber-500"></i>
                    <div>
                        <h5 class="text-xs font-bold text-amber-900 uppercase tracking-widest mb-1">Administrator Access</h5>
                        <p class="text-[11px] text-amber-700 leading-relaxed">As an administrator, you will always have full access to view and test all pages, regardless of the active mode. Public users will be redirected to designated splash pages.</p>
                    </div>
                </div>

                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Update Site Visibility
                </button>
            </form>
        </div>
        <!-- System Tools Tab -->
        <div x-show="tab === 'tools'" x-cloak class="space-y-8 animate-in fade-in duration-500">
             <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">System Maintenance Tools</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Manage application performance and assets</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Clear Cache -->
                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center mb-6">
                            <i class="ri-refresh-line text-2xl text-slate-900"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-3">Clear Application Cache</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed mb-8">This will flush the application, configuration, route, and view caches. Useful after making manual changes to configuration files or templates.</p>
                    </div>
                    <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Note: This might perform a slight reload of assets. Proceed?')" class="w-full py-4 px-6 bg-slate-900 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                            Execute Clear Cache
                        </button>
                    </form>
                </div>

                <!-- Storage Link -->
                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center mb-6">
                            <i class="ri-link-m text-2xl text-slate-900"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-3">Fix Storage Link</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed mb-8">Re-generates the symbolic link from public/storage to storage/app/public. Required for uploaded media and product images to display correctly.</p>
                    </div>
                    <form action="{{ route('admin.settings.storage-link') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 px-6 border-2 border-slate-900 text-slate-900 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">
                            Create Symbolic Link
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="p-6 bg-blue-50 border border-blue-100 rounded-xl flex items-center gap-4 mt-10">
                <i class="ri-information-line text-2xl text-blue-500"></i>
                <p class="text-[10px] text-blue-700 font-bold uppercase tracking-widest">Only use these tools when necessary during deployment or configuration debugging.</p>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

