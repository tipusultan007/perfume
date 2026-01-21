@extends('admin.layouts.app')

@section('title', 'Global Settings')
@section('page_title', 'Configuration')

@section('content')
<div class="max-w-4xl" x-data="{ tab: 'general' }">
    <!-- Tabs Nav -->
    <div class="flex flex-wrap items-center gap-3 mb-10">
        <button @click="tab = 'general'" 
            :class="tab === 'general' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-white text-slate-500 hover:bg-slate-50 border-slate-200'" 
            class="px-6 py-3.5 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-2">
            <i class="ri-settings-4-line text-sm"></i> General
        </button>
        <button @click="tab = 'contact'" 
            :class="tab === 'contact' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-white text-slate-500 hover:bg-slate-50 border-slate-200'" 
            class="px-6 py-3.5 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-2">
            <i class="ri-mail-line text-sm"></i> Contact
        </button>
        <button @click="tab = 'social'" 
            :class="tab === 'social' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-white text-slate-500 hover:bg-slate-50 border-slate-200'" 
            class="px-6 py-3.5 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-2">
            <i class="ri-links-line text-sm"></i> Social
        </button>
        <button @click="tab = 'navigation'" 
            :class="tab === 'navigation' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-white text-slate-500 hover:bg-slate-50 border-slate-200'" 
            class="px-6 py-3.5 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-2">
            <i class="ri-menu-line text-sm"></i> Navigation
        </button>
        <button @click="tab = 'footer'" 
            :class="tab === 'footer' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-white text-slate-500 hover:bg-slate-50 border-slate-200'" 
            class="px-6 py-3.5 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-2">
            <i class="ri-layout-bottom-line text-sm"></i> Footer
        </button>
        <button @click="tab = 'tax'" 
            :class="tab === 'tax' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-white text-slate-500 hover:bg-slate-50 border-slate-200'" 
            class="px-6 py-3.5 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-2">
            <i class="ri-percent-line text-sm"></i> Tax
        </button>
        <button @click="tab = 'announcement'" 
            :class="tab === 'announcement' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-white text-slate-500 hover:bg-slate-50 border-slate-200'" 
            class="px-6 py-3.5 text-[10px] uppercase tracking-widest font-bold border rounded-xl transition-all duration-300 flex items-center gap-2">
            <i class="ri-notification-badge-line text-sm"></i> Announcement
        </button>
    </div>

    @if(session('success'))
    <div class="mb-8 p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-widest flex items-center rounded-xl shadow-sm">
        <i class="ri-checkbox-circle-line mr-3 text-xl"></i> {{ session('success') }}
    </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-8 md:p-12">

        <!-- General Tab -->
        <div x-show="tab === 'general'" x-cloak class="space-y-8 animate-in fade-in duration-500">
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h3 class="text-lg font-bold text-slate-900">General Configuration</h3>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-bold">Standard Branding & Identity</p>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
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
    </div>
</div>
@endsection

@section('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

