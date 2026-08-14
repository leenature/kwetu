# Kwetu PMS - Current System Status

Prepared: 14 August 2026

## Purpose

This report describes the working feature set currently present in the Kwetu PMS codebase. It separates implemented capabilities from areas that are intentionally paused or need further production hardening.

## Platform summary

Kwetu PMS is a Laravel 12, Blade, Bootstrap 5 and MySQL property-management application. It supports organization-based workspaces for property owners and managers, a Super Admin control layer, public residence listings, and private tenant/client portal links.

## User roles and access

| Role | Current access |
| --- | --- |
| Super Admin | Global visibility; organizations, subscriptions, verification, users, all operational modules and landing/partner management. |
| Owner | Organization portfolio, users, bulk onboarding, clients, properties and all standard operational modules. |
| Manager | Properties, units, tenants, leases, maintenance, finance and reporting according to assigned permissions. |
| Accountant | Payments, expenses and reports according to assigned permissions. |
| Caretaker | Properties, units, tenants and maintenance according to assigned permissions. |

Records for properties, units, tenants, leases, payments and expenses are organization-scoped. Super Admin is the intended global exception.

## Implemented features

### Account and workspace management

- Registration creates an organization and an Owner account with a plan, subscription status and trial date.
- Login, password reset, profile editing and email-verification screens are present.
- Super Admin can list organizations, view their users and portfolios, and update plan/subscription/status details.
- Owners and Super Admins can manage staff roles and module access. The credential email template and database notification flow are present.
- Navbar notifications can be marked read.

### Dashboard and portfolio overview

- Dashboard KPI cards for property, unit, occupancy, tenant and active lease totals.
- Expected rent, recorded monthly collections, expenses, profit and outstanding amount calculations.
- Recent payments, monthly-revenue chart data, occupancy rate and property map pins when coordinates are recorded.
- Super Admin subscription metrics and organization overview.

### Properties and verification

- Create, edit, view, search and delete properties.
- Required latitude/longitude capture using an interactive Leaflet/OpenStreetMap map, location search and shared-map-link parsing.
- Property types, addresses, floors, descriptions, amenities, status, client/owner assignment and file uploads.
- Verification checklist, evidence/media storage, review status and Super Admin verification workspace.
- Property detail view with unit summary, expected rent, documents/media, service providers and a maintenance shortcut.

### Units, tenants and leases

- Units with number, type, bedrooms, bathrooms, floor, rent, deposit, status and description.
- Tenant creation creates an active lease and marks the chosen vacant unit occupied.
- Tenant editing/deletion; deletion releases active assigned units.
- Lease listing and creation.
- Unit lists filtered by property and available-unit API endpoint for forms.

### Finance and reports

- Manual payment records: view, add and delete.
- Manual expense records: create, update paid/pending/cancelled status and delete.
- Date-range reporting for income, paid expenses, income by property and expense categories.
- M-Pesa/STK integration, automatic reconciliation, invoices and automated arrears reminders are deliberately paused and are not represented as complete.

### Maintenance and local service providers

- Super Admin can create service providers, control public visibility and make each provider available at all or selected properties.
- Owners select available providers while creating or editing a property.
- Property detail pages show providers available for that property.
- Maintenance workspace allows staff to log/filter requests, assign an allowed property provider, record a quote, schedule work and change status from Open through Completed/Cancelled.
- Tenant portal users can submit maintenance requests for their active home.

### Portals and public experience

- Public landing page with configurable headline/text and service-provider strip.
- Public residence directory for verified properties with vacant units and property detail pages.
- Tenant portal link: active home summary and self-service maintenance requests. It does not yet expose payment balances, receipts, documents or notices.
- Client portal link: assigned properties, total/occupied/vacant units and expected monthly rent. It does not yet include statements, document sharing or messaging.

### Bulk onboarding

- Owners and Super Admins can download a CSV template.
- The template opens in Excel. One row represents one unit.
- Import creates properties, units, rents/deposits/statuses and, for occupied rows with tenant details, tenants and active leases.
- The importer validates required headers/values, runs as a database transaction and reports invalid CSV rows.

## Current navigation

Authenticated users can access Dashboard, Properties, Units, Tenants, Leases, Maintenance, Finance, Reports and Settings according to role/module permissions. Owners/Super Admins additionally see Bulk onboarding; users with property access see Clients. Super Admin sees Organizations and Verification.

## Data model at a glance

Organization -> Properties -> Units -> Leases -> Tenants/Payments

Organization -> Property clients -> Properties

Property -> Service providers (many-to-many)

Property/Unit/Tenant -> Maintenance requests -> optional Service provider

Property -> Verification items and uploaded files

## Production-readiness notes

- CSV, not native .xlsx, is supported. Excel can export the supplied template to CSV UTF-8.
- Portal URLs use long random tokens. Add token reset/revocation and an authenticated client/tenant login before using them for sensitive financial documents.
- Payments are manual records only; no payment gateway or bank/M-Pesa reconciliation is live.
- Lease edit, update and delete routes exist through Laravel resource routing, but their controller actions need implementation before they should be exposed as complete workflows.
- Automated test coverage is currently mainly Laravel/Breeze authentication/profile coverage. Core property, import, maintenance, portal and organization-isolation regression tests should be added before a production launch.
- Run a full user-acceptance test with real role accounts, SMTP configuration, file storage and a production database before launch.

## Recommended next priorities

1. End-to-end test and harden organization isolation, role access and every portal token.
2. Add lease lifecycle completion: editing, renewal, move-out and documented deposits.
3. Add provider quotes/attachments, SLA dates, completion evidence and ratings.
4. Add tenant notices/documents and client statements with authenticated portal accounts.
5. When payments resume, implement M-Pesa collection/reconciliation, receipts and arrears automation as a single tested workflow.

